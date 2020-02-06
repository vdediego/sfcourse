<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category.")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/category-listing.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name')
            ->add('description')
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();

            // Set category fields
            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['description']);

            // Entity Manager: interact with the DB
            $em = $this->getDoctrine()->getManager();

            // Final DB statement
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'A new category has been created successfully!');
            return $this->redirectToRoute('category.index');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Category $category
     * @return Response
     */
    public function delete(Category $category)
    {
        // Entity Manager: interact with the DB
        $em = $this->getDoctrine()->getManager();

        // Final DB statement
        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'A new category has been deleted successfully!');

        return $this->redirectToRoute('category.index');
    }
}
