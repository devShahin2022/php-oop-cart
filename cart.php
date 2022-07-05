<?php 
session_start();


// DB class  
class DB{
    public function data(){
        return $dataCenter = ["20","40","60","80"];
    }
}
//cart item manage class
class Cart extends DB{
    private $cartProductsPrice = [];
    private $totalPrice;
    public $productId;
    public $quantity;
    // get cart items f
    public function getCartItem(){
        return $_SESSION;
    }
    // product add
    public function productAddCart($id, $qnty){ // this function will be first call...
       
        $this->productId = "id_".$id;
        $this->quantity = $qnty;
        if($this->productExitCartCheck() === true){
            $getQnty = $_SESSION[$this->productId];
            $_SESSION[$this->productId] =  $getQnty + 1;
        }else{
            $_SESSION[$this->productId] = $qnty;
        }
    }
    // check product exit
    public function productExitCartCheck(){
        if(array_key_exists($this->productId,$_SESSION)){
            return true;
        }else{
            return false;
        }
    }
    // function for add quantity
    public function incressQuantity($productId, $amount=1){
        if($_SESSION[$productId] >10){
            die("we are support maximum 10 products.");
        }else{
            $_SESSION[$productId] += $amount;
        }
        return $_SESSION;
    }
        // function for remove quantity
        public function decressQuantity($productId){
            if($_SESSION[$productId] > 0){
                $_SESSION[$productId] -= 1;
            }else{
                die("Minimum quantity must be 1");
            }
            return $_SESSION;
        }
    // function for get every product price 
    function getCartProductPrice(){
        $i = 0;
        foreach ($_SESSION as $id => $quantity) {
            $actualId = $this->stringTorealIdFetch($id);
            // query for fetch data from database...
            $this->totalPrice += $this->data()[$i] * $quantity ;
            array_push($this->cartProductsPrice, $this->data()[$i] * $quantity);
            $i++ ;
        }
        return ["totalPrice"=>$this->totalPrice , "eachProdWithQutyPrice"=>$this->cartProductsPrice];   
    }
    // string to int id conversion
    public function stringTorealIdFetch($string_id){ // it's use for db query fetch price...
        return substr($string_id,3);
    }
}

$obj = new Cart();

$obj->productAddCart(14,1);


echo "<pre>";
print_r($obj->getCartItem());
echo "cart prices array";
echo "<pre>";
print_r($obj->getCartProductPrice());

?>