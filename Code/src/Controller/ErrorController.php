<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/error")
 */
class ErrorController extends AbstractController
{
    /**
     * @Route("/403", name="forbidden")
     */
    public function forbid(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error403.html.twig");
    }

    
    /**
     * @Route("/404", name="not_found")
     */
    public function notFound(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error404.html.twig");
    }

    /**
     * @Route("/500", name="serverr")
     */
    public function serverr(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error.html.twig");
    }

}
