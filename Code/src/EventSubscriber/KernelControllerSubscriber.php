<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\EtatRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KernelControllerSubscriber implements EventSubscriberInterface
{

  private $etatRepository;
  private $twig;

  public function __construct(
      EtatRepository $etatRepository, 
      Environment $twig
  )
  {
      $this->etatRepository = $etatRepository;
      $this->twig = $twig;
  }

    public function onKernelController(ControllerEvent $event)
    {
      $etats = $this->etatRepository->findAll();
      // envoyer les tags à Twig
      $this->twig->addGlobal('etats', $etats);

    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
