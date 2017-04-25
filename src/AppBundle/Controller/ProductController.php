<?php

namespace AppBundle\Controller;

use AppBundle\Entity\products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller {
    

    public function createAction() {
        $products = new Products();
        $products->setTitle('Keyboard');
        $products->setDescription('Ergonomic and stylish!');
        $products->setPrice(19.99);
        $products1 = new Products();
        $products1->setTitle('Mouse');
        $products1->setDescription('Ergonomic and stylish mouse!');
        $products1->setPrice(20.99);
        $products2 = new Products();
        $products2->setTitle('Monitor');
        $products2->setDescription('Ergonomic and stylish monitor!');
        $products2->setPrice(13.18);
        $products3 = new Products();
        $products3->setTitle('Notepad');
        $products3->setDescription('Ergonomic and stylish notepad!');
        $products3->setPrice(15.99);
        $products4 = new Products();
        $products4->setTitle('Laptop');
        $products4->setDescription('Ergonomic and stylish laptop!');
        $products4->setPrice(17.99);


        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($products);
        $em->persist($products1);
        $em->persist($products2);
        $em->persist($products3);
        $em->persist($products4);


        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new product with id ' . $products->getId());
        //return new Response('Uspesno ste uneli novi proizvod');
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
