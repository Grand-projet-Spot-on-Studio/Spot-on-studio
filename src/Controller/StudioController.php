<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\Studio;
use App\Form\StudioType;
use App\Repository\StudioRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudioController extends AbstractController
{
    /**
     * @Route ("/studio", name="display_studio")
     */
    public function displayStudio(StudioRepository $repository)
    {
        $studio = $repository->findAll();
        return $this->render('studio/display.studio.html.twig', [
            'studio' => $studio
        ]);
    }

    /**
     * @Route ("/insert/studio", name="insert_studio")
     */

    public function insertStudio(EntityManager $entityManager, Request $request)
    {
        $studio = new Studio();

        $form = $this->createForm(StudioType::class, $studio);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $studio = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            $media = $form->get('media')->getData();
            if (!empty($media)) {
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('studio_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le studio n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)
                    //le nom de mon media est le meme que le titre de la video
                    ->setName($form->get('name')->getData());

                $studio->addMedia($studio);

                $entityManager->persist($media);

            }
            $entityManager->persist($studio);
            $entityManager->flush();
            $this->addFlash('success',
                'le studio a été créé'
            );

            return $this->redirectToRoute('display_studio');
        }
        return $this->render('studio/insert_update_studio.html.twig', [
            'studio' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/studio/{id}", name="update_studio")
     */
    public function updateVideo(StudioRepository $studioRepository, $id, Request $request, EntityManagerInterface $entityManager)
    {
        $studio = $studioRepository->find($id);

        $form = $this->createForm(StudioType::class, $studio);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $studio = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            $media = $form->get('media')->getData();
            if(!empty($media)){
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('studio_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le studio n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)
                    //le nom de mon media est le meme que le titre de la video
                    ->setName($form->get('name')->getData());

                $studio->addMedia($studio);

                $entityManager->persist($media);

            }


            $entityManager->persist($studio);
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
     * @Route ("/delete/studio/{id}", name="delete_video")
     */

    public Function deleteStudio(StudioRepository $studioRepository, $id, EntityManagerInterface $entityManager)
    {
        $studio = $studioRepository->find($id);

        $entityManager->remove((object)$studio);

        $entityManager->flush();

        $this->addFlash(
            'success', 'Le studio a été bien suppirmé'
        );
        return $this->redirectToRoute('display_studio');
    }

    /**
     * @Route("/show/studio/{id}", name="show_stuido")
     */
    public function showStudio(StudioRepository $studioRepository, $id)
    {
        $studio = $studioRepository->find($id);
        return $this->render('studio/show_studio.html.twig',
            [
                'studio'=>$studio
            ]);
    }

}