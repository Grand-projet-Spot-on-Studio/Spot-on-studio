<?php


namespace App\Controller;


use App\Entity\Coach;
use App\Form\CoachType;
use App\Entity\Media;
use App\Repository\CoachRepository;
use App\Repository\StudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController

{
    /**
     * @Route ("/display/coach", name="display_coach")
     */
    public function displayCoach(CoachRepository $coachRepository)
    {
        $coach = $coachRepository->findAll();

        return $this->render('coach/display.coach.html.twig', [
            'coaches' => $coach
        ]);
    }

    /**
     * @Route ("/insert/coach", name="insert_coach")
     */

    public function insertCoach($id, EntityManagerInterface $entityManager, Request $request, StudioRepository $studioRepository)
    {
        $coach = new Coach();
        $studio = $studioRepository->find($id);

        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $coach = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            $media = $form->get('media')->getData();
            if(!empty($media)){
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('coach_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le coach n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)

                    ->setName($form->get('name')->getData());

                $coach->setMedia($media);

                $entityManager->persist($media);

            }
            $studio->addCoach($coach);
            $entityManager->persist($coach);
            $entityManager->flush();
            $this->addFlash('success',
                'le coach a été créé'
            );

            return $this->redirectToRoute('display_coach');
        }
        return $this->render('coach/insert_update_coach.html.twig', [
            'coach' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/coach/{id}", name="update_coach")
     */
    public function updateCoach(CoachRepository $coachRepository, $id, Request $request, EntityManagerInterface $entityManager)
    {
        $coach = $coachRepository->find($id);

        $form = $this->createForm(CoachType::class, $coach);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $coach = $form->getData();
            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
            $media = $form->get('media')->getData();
            if(!empty($media)){
                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
                try {
                    $media->move(
                        $this->getParameter('coach_directory'),
                        $newfiles
                    );

                } catch (FileException $e) {

                    throw new \Exception("le coach n\'a pas été enregistré");

                }
                $media = new Media();
                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
                $media->setUrl($newfiles)
                    ->setName($form->get('name')->getData());

                $coach->setMedia($media);
                $entityManager->persist($media);

            }


            $entityManager->persist($coach);
            $entityManager->flush();
            $this->addFlash('success',
                'le coach a été modifié'
            );

            return $this->redirectToRoute('display_coach');
        }
        return $this->render('coach/insert_update_coach.html.twig',[
            'coach' => $form->createView()
        ]);

    }

    /**
     * @Route ("/delete/coach/{id}", name="delete_coach")
     */

    public Function deleteStudio(CoachRepository $coachRepository, $id, EntityManagerInterface $entityManager)
    {
        $coach = $coachRepository->find($id);

        $entityManager->remove((object)$coach);

        $entityManager->flush();

        $this->addFlash(
            'success', 'Le coach a été bien suppirmé'
        );
        return $this->redirectToRoute('display_coach');
    }



}
