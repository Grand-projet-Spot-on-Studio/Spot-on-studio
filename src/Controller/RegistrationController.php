<?php

namespace App\Controller;

use App\Entity\Studio;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\StudioRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function registerResponsible(Request $request, UserPasswordEncoderInterface $passwordEncoder, StudioRepository $studioRepository): Response
    {
        $user = new User();
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


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

//            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('kevin.vandenbussche.pro@gmail.com', 'Spot On Studio'))
//                    ->to($user->getEmail())
//                    ->subject('veuillez confirmer le mail')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
//            // do anything else you need here, like send an email

            return $this->redirectToRoute('home_page');

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/register/responsible", name="app_register_responsible_studio")
     */
    public function registerResponsibleStudio(Request $request, UserPasswordEncoderInterface $passwordEncoder, StudioRepository $studioRepository): Response
    {
        $user = new User();
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

            $studio = new Studio();
            $entityManager = $this->getDoctrine()->getManager();
            $studio->setName('newStudio');
            $studio->setUserEmployed($user);
            $entityManager->persist($studio);

            $entityManager->persist($user);
            $entityManager->flush();

//            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('kevin.vandenbussche.pro@gmail.com', 'Spot On Studio'))
//                    ->to($user->getEmail())
//                    ->subject('veuillez confirmer le mail')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
//            // do anything else you need here, like send an email

            return $this->redirectToRoute('show_user', ['id'=>$user->getId()]);

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'votre mail a été verifier.');

        return $this->redirectToRoute('home_page');
    }
}
