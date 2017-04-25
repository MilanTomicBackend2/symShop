<?php

namespace AppBundle\Controller;

use AppBundle\Entity\products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\ProductType;

class ProductController extends Controller {
    

    public function createAction(Request $request) {
        
        $products = new Products();
        
        /*$products->setTitle('Keyboard');
        $products->setDescription('Ergonomic and stylish!');
        $products->setPrice(19.99);
        */
        
        $form = $this->createForm(ProductType::class,$products);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $products = $form->getData();
        
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($products);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        
        return $this->redirectToRoute('product_list');
        }

         return $this->render('product/create.html.twig', array(
        'form' => $form->createView(),
    ));
    }

    public function listAction() {

        $products = $this->getDoctrine()
                ->getRepository('AppBundle:products')
                ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                    'No product found '
            );
        }
        //var_dump($products);
        //return new Response('uspesno'.$products);
        return $this->render('product/list.html.twig', [
                   'products' => $products
        ]);
    }

    public function showAction($name) {


        $products = $this->getDoctrine()
                ->getRepository('AppBundle:products')
                ->findOneByTitle($name);

        if (!$products) {
            throw $this->createNotFoundException(
                    'No product found '
            );
        }

        return $this->render('product/show.html.twig', ['product' => $products]);
    }


    public function homepageAction() {
        
        $products = $this->getDoctrine()
                ->getRepository('AppBundle:products')
                ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                    'No product found '
            );
        }

        return $this->render('product/homepage.html.twig', ['homepage' => $products]);
    }

}
