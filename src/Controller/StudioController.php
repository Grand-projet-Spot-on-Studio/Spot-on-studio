<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\Studio;
use App\Form\StudioType;
use App\Repository\StatusRepository;
use App\Repository\StudioRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\TimeConverteur\TimeConverteur;
use Symfony\Component\String\Slugger\AsciiSlugger;

class StudioController extends AbstractController
{
    /**
     * @Route ("/display/studio", name="display_studio")
     */
    public function displayStudio(StudioRepository $repository, PaginatorInterface $paginator, Request $request)
    {
        $studios = $repository->findAll();

        $studios = $paginator->paginate(
            $studios, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );
        return $this->render('studio/display.studio.html.twig', [
            'studios' => $studios
        ]);
    }
//
//    /**
//     * @Route ("/insert/studio", name="insert_studio")
//     */
//
//    public function insertStudio(EntityManagerInterface $entityManager, Request $request)
//    {
//        $studio = new Studio();
//
//        $form = $this->createForm(StudioType::class, $studio);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $studio = $form->getData();
//            //je recupere le formulaire de media pour pouvoir completer les données dans l'entité media
//            $media = $form->get('media')->getData();
//            if(!empty($media)){
//                $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
//                try {
//                    $media->move(
//                        $this->getParameter('studio_directory'),
//                        $newfiles
//                    );
//
//                } catch (FileException $e) {
//
//                    throw new \Exception("le studio n\'a pas été enregistré");
//
//                }
//                $media = new Media();
//                //dans l'entité media le champ url est remplie par le nom qui est dans $newfile
//                $media->setUrl($newfiles)
//                    //le nom de mon media
//                    ->setName('picture');
//
//                $studio->addMedia($studio);
//
//                $entityManager->persist($media);
//            }
//
//            $entityManager->persist($studio);
//            $entityManager->flush();
//            $this->addFlash('success',
//                'le studio a été créé'
//            );
//
//            return $this->redirectToRoute('display_studio');
//        }
//        return $this->render('studio/insert_update_studio.html.twig', [
//            'studio' => $form->createView()
//        ]);
//    }

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
            //////////////////////////////////////////////////
            $slugger = new AsciiSlugger();
            $nameSlug = $form->get('name')->getData();
            $slug = $slugger->slug($nameSlug);
            $studio->setSlugName($slug);
            //////////////////////////////////////////////////
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
                    ->setName('picture');

                $studio->addMedia($media);
                $entityManager->persist($media);
            }
            $entityManager->persist($studio);
            $entityManager->flush();
            $this->addFlash('success',
                'le studio a été modifié ou crée'
            );

            return $this->redirectToRoute('show_studio', ['name' => $studio->getSlugName(), 'id'=>$studio->getid()]);
        }
        return $this->render('studio/insert_update_studio.html.twig',[
            'studio' => $form->createView()
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
     * @Route("/show/studio/{name}/{id}", name="show_studio")
     */
    public function showStudio(StudioRepository $studioRepository,
                               $id,
                               VideoRepository $videoRepository,
                               PaginatorInterface $paginator,
                               Request $request,
                               TimeConverteur $timeConverteur
    )
    {
        $studio = $studioRepository->find($id);
        $videos = $videoRepository->findBy(['studio' => $id]);
        $todayDay = new \DateTime('now');
        if(!empty($video)){
            //methode qui me permet de recuperer la date de publication qui est en base de donnée
            $dateDatabase = $videoRepository->datePublished();
            foreach ($videos as $video){
                $status = $video->getStatus();
                ($todayDay >= $dateDatabase) ? $status->setName('asPublished') : $status->setName('notPublished');;
            }
            $duration = $video->getDuration();
            //methode qui permet de convertir les secondes en h:m:s
            $video->setDuration($timeConverteur->ConvertisseurTime($duration));
            $videos = $paginator->paginate(
                $videos, // Requête contenant les données à paginer (video)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                5 // Nombre de résultats par page
            );

            return $this->render('studio/show_studio.html.twig',
                [
                    'videos'=> $videos,
                    'studio' => $studio
                ]);

        }

        return $this->render('studio/show_studio.html.twig',
            [
                'studio' => $studio
            ]);
    }

}
