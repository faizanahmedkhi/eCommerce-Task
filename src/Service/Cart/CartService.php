<?php

namespace App\Service\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;

class CartService{
 
    protected $session;
    protected $productRepository; 

    public function __construct(SessionInterface $session, ProductRepository $productRepository){
       $this->session = $session;
       $this->productRepository = $productRepository;
    }

     public function add(int $id){

        $basket  = $this->session->get('basket', []);        
            
        if(!empty($basket[$id])){
            $basket[$id]++;                  
        }
        else{
            $basket[$id] = 1;
            
        }
        
        $this->session->set('basket', $basket);

     }
     

     public function remove(int $id){
        $basket = $this->session->get('basket', []);

        if(!empty($basket[$id])){
            unset($basket[$id]);
        }

        $this->session->set('basket', $basket);
     }


     public function getFullCart(): array {
        $basket = $this->session->get('basket');
        $basketWithData = [];        
        foreach($basket as $id => $quntity){
            $basketWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' =>  $quntity
            ];
        }
        
        return $basketWithData;
     }
       

     public function getTotal() : float {
        
        $total = 0;                
        foreach($this->getFullCart() as $item){
            
             $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
     }
}


