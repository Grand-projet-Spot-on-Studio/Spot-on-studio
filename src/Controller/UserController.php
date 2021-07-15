<?php


namespace App\Controller;


use App\Form\RegistrationFormType;
use App\Repository\StudioRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/show/user/{id}", name = "show_user")
     */

    public function showUser($id, UserRepository $userRepository, StudioRepository $studioRepository)
    {
        $user = $userRepository->find($id);
        $studio = $studioRepository->findOneBy(['user_employed' => $id]);

        return $this->render('user_studio/user_studio.html.twig', [
            'user' => $user,
            'studio' => $studio
        ]);
    }

    /**
     * @Route("/update/user/{id}", name="update_user")
     */

    public function updateUser(Request $request,
                               UserPasswordEncoderInterface $passwordEncoder,
                               $id,
                               UserRepository $userRepository,
                               EntityManagerInterface $entityManager)
    {
        $user = $userRepository->find($id);

        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )

            );


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('show_user', ['id' => $user->getId()]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

}