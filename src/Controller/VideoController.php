<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\Status;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\MediaRepository;
use App\Repository\StatusRepository;
use App\Repository\StudioRepository;
use App\Repository\VideoRepository;
use App\TimeConverteur\TimeConverteur;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class VideoController extends AbstractController
{
    /**
     * @Route ("display/video/{id}", name="display_video")
     */

    public function displayVideo(VideoRepository $videoRepository, StudioRepository $studioRepository, $id)
    {
        $studio = $studioRepository->find($id);
        $videos = $videoRepository->findBy(['studio'=>$studio]);

        return $this->render('video/display_video.html.twig',[
            'videos'=>$videos
        ]);
    }

    /**
     * @Route ("/insert/video/{id}", name="insert_video")
     */
    public function insertVideo ($id,
                                 EntityManagerInterface $entityManager,
                                 Request $request,
                                 StudioRepository $studioRepository,
                                StatusRepository $statusRepository
                                )
    {
        $video = new Video();
        $studio = $studioRepository->find($id);


        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $video = $form->getData();

            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            if($form->isSubmitted() && $form->isValid()){

                $status = $form['status']->getData();
                $video->setStatus($status);
                $coach = $form['coach']->getData();
                $video->setCoach($coach);


                $newMedia = $form['media']->getData();
                if(!empty($newMedia)) {
                    $newfiles = md5(uniqid()) . '.' . $newMedia->guessExtension();
                    try {
                        $newMedia->move(
                            $this->getParameter('video_directory'),
                            $newfiles
                        );

                    } catch (FileException $e) {

                        throw new \Exception("le flux vidéo n\'a pas été enregistré");

                    }
                    $media = new Media();
                    $media->setVideo($video);
                    $media->setName('picture');
                    $media->setUrl($newfiles);
                    $entityManager->persist($media);
                }

            }
            $video->setStudio($studio);
            $entityManager->persist($video);
            $entityManager->flush();
            $this->addFlash('success',
                'le cours a été créé'
            );
            return $this->redirectToRoute('show_video', ['name'=>$studio->getSlugName(), 'id'=>$video->getId()]);
        }
        return $this->render('video/insert_update_video.html.twig',[
                'video' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/video/{studio}/{id}", name="update_video")
     */
    public function updateVideo(VideoRepository $videoRepository,
                                StudioRepository $studioRepository,
                                $id,
                                $studio,
                                Request $request,
                                EntityManagerInterface $entityManager,
                                MediaRepository $mediaRepository
    )
    {
        $video = $videoRepository->find($id);
        $studio = $studioRepository->find($studio);

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $video = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            if($form->isSubmitted() && $form->isValid()) {

                $status = $form['status']->getData();
                $video->setStatus($status);

                $coach = $form['coach']->getData();
                $video->setCoach($coach);


                $newMedia = $form['media']->getData();
                if (!empty($newMedia)) {
                    $newfiles = md5(uniqid()) . '.' . $newMedia->guessExtension();
                    try {
                        $newMedia->move(
                            $this->getParameter('video_directory'),
                            $newfiles
                        );

                    } catch (FileException $e) {

                        throw new \Exception("le flux vidéo n\'a pas été enregistré");

                    }
                    $media = new Media();
                    $media->setVideo($video);
                    $media->setName('picture');
                    $media->setUrl($newfiles);
                    $entityManager->persist($media);
                }
            }

            $entityManager->persist($video);
            $entityManager->flush();
            $this->addFlash('success',
                'le cours a été créé'
            );

            return $this->redirectToRoute('show_video', ['id'=>$video->getId()]);
        }
        return $this->render('video/insert_update_video.html.twig',[
            'video' => $form->createView()
        ]);
    }

    /**
     * @Route ("/delete/video/{id}", name="delete_video")
     */

    public Function deleteVideo(VideoRepository $videoRepository,
                                $id,
                                EntityManagerInterface $entityManager,
                                MediaRepository $mediaRepository
                                )
    {
        $filesystem = new Filesystem();
        $video = $videoRepository->find($id);
        $media = $mediaRepository->findOneBy(['video'=>$id]);

        ///////////////////////////////////logique pour supprimer les fichiers dans le dossier public//////////////////////////////
        //je recupere la miniature de la video
        $filesNamePicture = $media->getName();
        //je recupere le nom du fichcier du flux d'image
        $filesNameVideo = $media->getUrl();
        //je dis a symfony qu'il doit aller dans un dossier
        $projectDir = $this->getParameter('kernel.project_dir');
        //je lui indique la route ou il doit aller chercher le fichier
        $webPath = $projectDir . '\public\video\\';
        //je supprimme le fichier
        $filesystem->remove($webPath . $filesNameVideo);
        $filesystem->remove($webPath . $filesNamePicture);
        ////////////////////////////////////////////////////////////////////////////////////////////////////

        $entityManager->remove((object)$video);
        $entityManager->flush();

        $this->addFlash(
            'success', 'La video a été bien suppirmé'
        );
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/show/video/{name}/{id}", name="show_video")
     */
    public function showVideo(VideoRepository $videoRepository,
                              $id,
                              TimeConverteur $timeConverteur,
                              $name)
    {

       $videos = $videoRepository->videoByStudio($name, $id);
       $video = $videos['0'];


        foreach($videos as $video) {
            $studio = $video->getStudio();
            $media  = $video->getMedia();
            foreach ($video as $data){
                $duration = $data->getDuration();
            }
        }
        if(!empty($duration)){
            $timeMedia = $timeConverteur->ConvertisseurTime($duration);
            $statusDataBase= $video->getStatus()->getName();
            $datePublished = $video->getProgrammingDate();
            $dateCreated = $video->getcreatedAt();
            if($statusDataBase == 'published' && $datePublished <= $dateCreated){
                $status = 'published';
            }else{
                $status = 'notPublished';
            }
            return $this->render('video/show_video.html.twig', [
                'video'=>$video,
                'timeVideo'=>$timeMedia,
                'status'=>$status
            ]);
        }

        return $this->render('video/show_video.html.twig', [
            'video'=>$video,
            'studio'=>$studio,
            'media'=>$media
        ]);

    }



}
