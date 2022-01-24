<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/category")
 */
class CategorieController extends AbstractController
{
    // /*
    //  * @Route("/category", name="category")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('categorie/index.html.twig', [
    //         'controller_name' => 'CategorieController',
    //     ]);
    // }
    
    /**
     * @Route("/add", name="add_category")
     */
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        // creates a category object and initializes some data for this example
        $category = new Categorie();
        $category->setNom('Nom de la categorie');

        $form = $this->createFormBuilder($category)
            ->add('nom', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Category'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            //return new Response('Saved new category with name : '.$category->getNom().' and id : '.$category->getId());
            return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/add.html.twig', [
            'form' => $form,
        ]);
    }
    
    /*
     * @Route("/", name="categories")
     */
    public function list(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/list.html.twig', [
            'categories' => $categorieRepository->findAll()
        ]);
    }
    
    /*
     * @Route("/edit/{id}", name="edit_category", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categorie $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /*
     * @Route("/delete/{id}", name="delete_category", methods={"POST"})
     */
    public function delete(Request $request, Categorie $category, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }
        return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
    }

}
