<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\Status;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\MediaRepository;
use App\Repository\StatusRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class VideoController extends AbstractController
{
    /**
     * @Route ("display/video", name="display_video")
     */

    public function displayVideo(VideoRepository $videoRepository)
    {
        $videos = $videoRepository->findAll();

        return $this->render('video/video.html.twig',[
            'videos'=>$videos
        ]);
    }

    /**
     * @Route ("/insert/video", name="insert_video")
     */
    public function insertVideo (EntityManagerInterface $entityManager, Request $request)
    {
        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $video = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            if($form->isSubmitted() && $form->isValid()){

                //pour changer en base de donné le 0 ou 1
                $status = $form['status']->getData();
                ($status == 1) ? $status = 'notPublished' : $status = 'asPublished';

                $dataStatus = new Status();
                $dataStatus->setName($status);
                $dataStatus->addVideo($video);
                $entityManager->persist($dataStatus);

                $newMedia = $form['media']->getData();

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

            $entityManager->persist($video);



            $entityManager->flush();
            $this->addFlash('success',
                'le cours a été créé'
            );
            return $this->redirectToRoute('display_video');
        }
        return $this->render('video/insert_update_video.html.twig',[
                'video' => $form->createView()
        ]);


    }

    /**
     * @Route("/update/video/{id}", name="update_video")
     */
    public function updateVideo(VideoRepository $videoRepository, $id, Request $request, EntityManagerInterface $entityManager)
    {
        $video = $videoRepository->find($id);

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $video = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            if($form->isSubmitted() && $form->isValid()){
                $newMedia = $form['media']->getData();

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

            $entityManager->persist($video);

            $entityManager->flush();
            $this->addFlash('success',
                'le cours a été créé'
            );
            return $this->redirectToRoute('display_video');
        }
        return $this->render('video/insert_update_video.html.twig',[
            'video' => $form->createView()
        ]);


    }

    /**
     * @Route ("/delete/video/{id}", name="delete_video")
     */

    public Function deleteVideo(VideoRepository $videoRepository, $id, EntityManagerInterface $entityManager)
    {
        $video = $videoRepository->find($id);

        $entityManager->remove((object)$video);

        $entityManager->flush();

        $this->addFlash(
            'success', 'La video a été bien suppirmé'
        );
        return $this->redirectToRoute('display_video');
    }

    /**
     * @Route("/show/video/{id}", name="show_video")
     */
    public function showVideo(VideoRepository $videoRepository, $id)
    {
        $video = $videoRepository->find($id);

        return $this->render('video/show_video.html.twig', [
            'video'=>$video
        ]);
    }



}