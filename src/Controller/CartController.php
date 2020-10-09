<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use App\Service\Cart\CartService;


class CartController extends AbstractController
{
    /**
     * @Route("/basket", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
        
        ]);
    }

    /**
     * @Route("/basket/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService){
             
             $cartService->add($id);

            return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/basket/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService){
        
           $cartService->remove($id);

           return $this->redirectToRoute("cart_index");
    }
}
