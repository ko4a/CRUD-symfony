<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ProductRepository $productRepository,EntityManagerInterface $manager)
    {

        $this->productRepository = $productRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('index.html.twig',['products' => $this->productRepository->findAll()]);
    }

    /**
     * @param int $id
     * @Route("/product/{id}",name="show_product", requirements={"id"="\d+"})
     * @return Response
     */
    public function show(int $id)
    {
        $product =$this->productRepository->findOneBy(['id'=>$id]);
        return $this->render('show.html.twig',['product' => $product]);
    }

    /**
     * @Route("/product/edit/{id}",name="edit_product",methods={"GET"})
     */
    public function getEditForm(int $id)
    {
        $product =$this->productRepository->findOneBy(['id'=>$id]);
        return $this->render("edit.html.twig",['product'=>$product]);
    }

    /**
     * @Route("/product/edit/{id}",name="edit",methods={"POST"})
     */
    public function edit(int $id,Request $request)
    {
        $product =$this->productRepository->findOneBy(['id'=>$id]);
        $product->setPrice($request->request->get('price'));
        $product->setName($request->request->get('name'));
        $this->manager->persist($product);
        $this->manager->flush();
        return $this->redirectToRoute('product');
    }

    /**
     * @Route("/product/delete/{id}",name="delete_product")
     */
    public function delete(int $id)
    {
        $this->manager->remove($this->productRepository->findOneBy(['id'=>$id]));
        $this->manager->flush();
        return $this->redirectToRoute('product');
    }

    /**
     * @Route("/product/new",name = "new_product",methods={"GET"})
     */
    public function getCreateForm()
    {
        return $this->render('create.html.twig');
    }


    /**
     * @Route("/product/new",name = "create_product",methods={"POST"})
     */
    public function new(Request $request)
    {
        $product = new Product();
        $product->setName($request->request->get('name'));
        $product->setPrice($request->request->get('price'));
        $this->manager->persist($product);
        $this->manager->flush();
        return $this->redirectToRoute('product');
    }

}
