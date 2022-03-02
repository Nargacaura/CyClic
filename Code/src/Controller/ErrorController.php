<?php

/**
 * <h1>Contrôleur d'erreurs</h1>
 * <p>Contrôleur à usage de debug</p>
 * @author Damien Ledda
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

/**
 * <h2>Erreurs</h2>
 * <p>Liste les erreurs pour des raisons de debug niveau front.</p>
 */
/**
 * @Route("/error")
 */
class ErrorController extends AbstractController
{
    /**
     * @Route("/403", name="forbidden")
     * <h3>Erreur 403</h3>
     * @return error403.html.twig la page d'erreur 403
     */
    public function forbid(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error403.html.twig");
    }

    /**
     * @Route("/404", name="not_found")
     * <h3>Erreur 404</h3>
     * @return error404.html.twig la page d'erreur 404
     */
    public function notFound(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error404.html.twig");
    }

    /**
     * <h3>Erreur 500</h3>
     * @Route("/500", name="serverr")
     * @return error500.html.twig la page d'erreur 500
     */
    public function serverr(): Response
    {
        return $this->render("bundles/TwigBundle/Exception/error.html.twig");
    }

}
