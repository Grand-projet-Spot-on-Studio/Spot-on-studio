<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\Video;
use App\Form\VideoType;
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

    public function displayClasses(VideoRepository $videoRepository)
    {
        $classes = $videoRepository->findAll();
        return $this->render('video/video.html.twig',[
        'videos'=>$classes
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
            $media = $form->get('media')->getData();
            if(!empty($media)){
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('media_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le flux vidéo n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)
                    //le nom de mon media est le meme que le titre de la video
                    ->setName($form->get('title')->getData());

                $video->addMedia($video);

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
            $media = $form->get('media')->getData();
            if(!empty($media)){
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('media_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le flux vidéo n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)
                    //le nom de mon media est le meme que le titre de la video
                    ->setName($form->get('title')->getData());

                $video->addMedia($video);

                $entityManager->persist($media);

            }


            $entityManager->persist($video);
            $entityManager->flush();
            $this->addFlash('success',
                'le cours a été modifié'
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
        return $this->render('video/show_video.html.twig',
        [
            'video'=>$video
        ]);
    }



}