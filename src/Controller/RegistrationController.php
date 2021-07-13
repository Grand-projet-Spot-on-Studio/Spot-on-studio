<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
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



//    /**
//     * @Route("/register", name="app_register")
//     */
//    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
//    {
//        $user = new User();
//        $form = $this->createForm(RegistrationFormType::class, $user);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            // encode the plain password
//            $user->setPassword(
//                $passwordEncoder->encodePassword(
//                    $user,
//                    $form->get('plainPassword')->getData()
//                )
//
//            );
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
//
//            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('kevin.vandenbussche.pro@gmail.com', 'Spot On Studio'))
//                    ->to($user->getEmail())
//                    ->subject('veuillez confirmer le mail')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
//            // do anything else you need here, like send an email
//
//            return $this->redirectToRoute('home_page');
//
//        }
//
//        return $this->render('registration/register.html.twig', [
//            'registrationForm' => $form->createView(),
//        ]);
//    }


    /**
     * @Route("/email", name="test")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('kevin.vandenbussche.pro@gmail.com')
            ->to('nivek033@msn.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        return $this ->redirectToRoute('home_page');

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
