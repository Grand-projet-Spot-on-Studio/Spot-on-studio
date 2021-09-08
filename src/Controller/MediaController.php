<?php


namespace App\Controller;


use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Repository\StudioRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MediaController extends AbstractController
{
    /**
     * @Route("/media/video/{name}/{id}", name="media_video")
     */
    public function insertMediaVideo(
        EntityManagerInterface $entityManager,
        VideoRepository $videoRepository,
        $id,
        $name,
        Request $request,
        StudioRepository $studioRepository

    )
    {
        $studioArray = $studioRepository->selectByStudio($name);
        $studio = $studioArray['0'];
        $media = new Media();
        //class php qui me permet  d'analyser les fichiers téléchargé
        //composer require james-heinrich/getid3
        $getId3 = new \getID3();
        $video = $videoRepository->find($id);
        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $newMedia = $form['url']->getData();

            $newfiles = md5(uniqid()) . '.' . $newMedia->guessExtension();
            try {
                $newMedia->move(
                    $this->getParameter('video_directory'),
                    $newfiles
                );

            } catch (FileException $e) {

                throw new \Exception("le flux vidéo n\'a pas été enregistré");

            }

            $media->setVideo($video);
            $media->setName('video');
            $media->setUrl($newfiles);
            $entityManager->persist($media);
            //j'analyse le fichier et getid3 me sort un tableau avec toutes les données
            $file = $getId3->analyze('video/'.$media->getUrl());
            //je recupere le temps de la video qui est l'index playtime
            $duration = $file['playtime_seconds'];
            //je le mets dans l'attribut duration de mon entité vidéo
            $video->setDuration($duration);
            $entityManager->flush();
            return $this->redirectToRoute('show_video',[
                'name'=>$studio->getSlugName(),
                'id'=>$id,

            ]);

        }
        return $this->render('video/insert_update_image_stream.html.twig',[
            'media' => $form->createView(),
            'video'=>$video,
            'studio'=>$studio
        ]);
    }

    /**
     * @Route("update/media/video/{fluxMedia}/{id}", name="update_media_video")
     */
    public function updateMediaVideo(
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepository,
        VideoRepository $videoRepository,
        $id,
        $fluxMedia,
        Request $request
    )
    {
        $video = $videoRepository->find($id);
        $media = $mediaRepository->find($fluxMedia);
        $filesystem = new Filesystem();
        $getId3 = new \getID3();

        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //je recupere le nom du fichier du flux d'image
            $filesNameVideo = $media->getUrl();
            //je dis a symfony qu'il doit aller dans un dossier
            $projectDir = $this->getParameter('kernel.project_dir');
            //je lui indique la route ou il doit aller chercher le fichier
            $webPath = $projectDir . '\public\video\\';
            //je supprimme le fichier
            $filesystem->remove($webPath . $filesNameVideo);


            $newMedia = $form['url']->getData();

            $newfiles = md5(uniqid()) . '.' . $newMedia->guessExtension();
            try {
                $newMedia->move(
                    $this->getParameter('video_directory'),
                    $newfiles
                );

            } catch (FileException $e) {

                throw new \Exception("le flux vidéo n\'a pas été enregistré");

            }


            $media->setVideo($video);
            $media->setName('video');
            $media->setUrl($newfiles);
            $entityManager->persist($media);
            $file = $getId3->analyze('video/'.$media->getUrl());
            //je recupere le temps de la video qui est l'index playtime
            $duration = $file['playtime_seconds'];
            //je le mets dans l'attribut duration de mon entité vidéo
            $video->setDuration($duration);

            $entityManager->flush();
            return $this->redirectToRoute('show_video',[
                'id'=>$id,
                'video'=>$video

            ]);

        }

        return $this->render('video/insert_update_image_stream.html.twig',[
            'media' => $form->createView(),
            'video'=>$video
        ]);
    }

}
