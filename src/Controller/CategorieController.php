<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryType;
use App\Repository\CategorieRepository;
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
 * @author SCHAEFFER Léonard
 * <h1>Catégorie controller</h1>
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/add", name="add_category")
     * <h2>Function permetant le rajout de catégorie</h>
     * @param $request
     * @param $doctrine
     * @return $this->renderForm('categorie/add.html.twig', ['form' => $form,]);
     */
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
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
            return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie/add.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/", name="categories")
     * <h2>Liste les catégories</h2>
     * @param $categorieRepository
     * @return $this->render('categorie/list.html.twig', ['categories' => $categorieRepository->findAll()]);
     */
    public function list(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/list.html.twig', [
            'categories' => $categorieRepository->findAll()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit_category", methods={"GET", "POST"})
     * <h2>Modifie une catégorie</h2>
     * @param $request
     * @param $category
     * @param $entityManager
     * @return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
     * <h3>else</h3>
     * @return $this->renderForm('categorie/edit.html.twig', ['category' => $category,'form' => $form,]);
     */
    public function edit(Request $request, Categorie $category, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
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

    /**
     * @Route("/delete/{id}", name="delete_category", methods={"POST"})
     * <h2>Supprimer une catégorie</h2>
     * @param $request
     * @param $category
     * @param $doctrine
     * @return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
     */
    public function delete(Request $request, Categorie $category, ManagerRegistry $doctrine): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }
        return $this->redirectToRoute('categories', [], Response::HTTP_SEE_OTHER);
    }
}
