<?php

namespace App;

use Session;

class Cart {

    public $groomings = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public function __construct($oldCart) {
        if($oldCart) {
            $this->groomings = $oldCart->groomings;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }
    public function add($grooming, $id){
        //dd($this->groomings);
        $storedItem = ['qty'=>0, 'price'=>$grooming->price, 'grooming'=> $grooming];
        
        if ($this->groomings){
            if (array_key_exists($id, $this->groomings)){
                $storedItem = $this->groomings[$id];
                $this->totalPrice  -= $grooming->price;
                $this->totalQty --;
            } 
        }
        
        $storedItem['qty'] = 1;
        $storedItem['price'] = $grooming->price;
        $this->totalPrice += $grooming->price;
        $this->totalQty++;
       //$storedItem['qty'] += $grooming->qty;
        $this->groomings[$id] = $storedItem;
        
        
    }
    // public function reduceByOne($id){
    //     $this->groomings[$id]['qty']--;
    //     $this->groomings[$id]['price']-= $this->groomings[$id]['grooming']['sell_price'];
    //     $this->totalQty --;
    //     $this->totalPrice -= $this->groomings[$id]['grooming']['sell_price'];
    //     if ($this->groomings[$id]['qty'] <= 0) {
    //         unset($this->groomings[$id]);
    //     }
// }
 public function removeItem($id){
    //dd($this->groomings);
        $this->totalQty -= $this->groomings[$id]['qty'];
        $this->totalPrice -= $this->groomings[$id]['price'];
        unset($this->groomings[$id]);
    }
}