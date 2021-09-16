<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LandingPage extends AbstractController

{
    /**
     * @Route("/", name = "landing_page")
     */
    public function landingPage()
    {
        return $this->render('landing_page.html.twig');
    }

}