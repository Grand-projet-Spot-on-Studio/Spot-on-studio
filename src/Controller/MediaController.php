<?php


namespace App\Controller;


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
    public function mediaVideo(
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepository,
        $id,
        VideoRepository $videoRepository,
        Request $request
    )
    {

        $media = $mediaRepository->findByVideo($id);

        $video = $videoRepository->find($id);

        $form = $this->createForm(MediaType::class, $media);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $media = $form->getData();

            $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
            try {
                $media->move(
                    $this->getParameter('video_directory'),
                    $newfiles
                );

            } catch (FileException $e) {

                throw new \Exception("le flux vidéo n\'a pas été enregistré");

            }

            $media->setName($video->getTitle());
            $media ->setUrl($newfiles);
            $entityManager->persist($media);
            $entityManager->flush();







        }




    }

}