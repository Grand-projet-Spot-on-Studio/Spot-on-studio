<?php


namespace App\Controller;


use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MediaController extends AbstractController
{
    /**
     * @Route("/media/video/{id}", name="media_video")
     */
    public function insertMediaVideo(
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepository,
        VideoRepository $videoRepository,
        $id,
        Request $request
    )
    {

        $media = new Media();
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
            $entityManager->flush();
            return $this->redirectToRoute('show_video',[
                'id'=>$id,

            ]);

        }
        return $this->render('video/insert_update_image_stream.html.twig',[
            'media' => $form->createView(),
            'video'=>$video
        ]);
    }

    /**
     * @Route("update/media/video/{id}", name="update_media_video")
     */
    public function updateMediaVideo(
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepository,
        VideoRepository $videoRepository,
        $id,
        Request $request
    )
    {
        $media = new Media;
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
            $entityManager->flush();
            return $this->redirectToRoute('show_video',[
                'id'=>$id,
                'video'=>$video
            ]);

        }
        return $this->render('video/insert_update_image_stream.html.twig',[
            'media' => $form->createView()
        ]);
    }

}