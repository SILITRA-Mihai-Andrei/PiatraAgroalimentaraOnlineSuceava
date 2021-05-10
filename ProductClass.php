<?php

require_once ("strings.php");

class ProductClass{

    public $id;
    public $name;
    public $seller;
    public $category;
    public $price;
    public $amount = 0;
    public $amount_type="";
    public $special = 0;
    public $description="";

    public $category_name = "";
    public $seller_name = "";
    public $inventory = 0;
    public $inventoryAmountType = "";

    public function __construct () {}
    public function ProductClass() {}

    public static function loadProductById ($pdo, $id) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id=?');
        $stmt->execute([$id]);
        $record = $stmt->fetchObject(__CLASS__);
        // Set category name by using the product id
        $record->category_name = 
        $pdo->query("SELECT name FROM categories WHERE id='{$record->getCategory()}'")
            ->fetchColumn();
    // Set seller name by using the seller user id
    $_seller_name = $pdo->query("SELECT ".STR_NAME_DB." FROM users WHERE ".
    STR_ID_DB."={$record->getSeller()}".
    " AND ".STR_TYPE_DB."=1")
        ->fetchColumn();
    if($_seller_name != FALSE)
        $record->seller_name = $_seller_name;
    // Set the inventory amount for the product
    $record->inventory = 
        $pdo->query("SELECT amount, amount_type FROM inventories WHERE id_product=".$record->getId())
            ->fetchColumn();
    // Set the inventory amount type for the product
    $record->inventoryAmountType = 
        $pdo->query("SELECT amount_type FROM inventories WHERE id_product=".$record->getId())
            ->fetchColumn();
        return $record;
     }
    
     public static function loadProducts ($pdo, $special=FALSE) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE special='.($special ? '1' : '0'));
        $stmt->execute();
        $array = array();
        while( $record = $stmt->fetchObject(__CLASS__) ){
            // Set category name by using the product id
           $record->category_name = 
           $pdo->query("SELECT name FROM categories WHERE id='{$record->getCategory()}'")
               ->fetchColumn();
       // Set seller name by using the seller user id
       $_seller_name = $pdo->query("SELECT ".STR_NAME_DB." FROM users WHERE ".
       STR_ID_DB."={$record->getSeller()}".
       " AND ".STR_TYPE_DB."=1")
           ->fetchColumn();
       if($_seller_name != FALSE)
           $record->seller_name = $_seller_name;
       // Set the inventory amount for the product
       $record->inventory = 
           $pdo->query("SELECT amount, amount_type FROM inventories WHERE id_product=".$record->getId())
               ->fetchColumn();
       // Set the inventory amount type for the product
       $record->inventoryAmountType = 
           $pdo->query("SELECT amount_type FROM inventories WHERE id_product=".$record->getId())
               ->fetchColumn();
            array_push($array, $record);
        }
        return $array;
     }

     

    public function getId (){
         return $this->id;
     }

    public function getName (){
        return $this->name;
    }

    public function getSeller(){
        return $this->seller;
    }

    public function getCategory (){
        return $this->category;
    }

    public function getPrice (){
        return $this->price;
    }

    public function getAmount (){
        return $this->amount;
    }

    public function getAmountType (){
        return $this->amount_type;
    }

    public function getDescription (){
        return $this->description;
    }

    public function getCategoryName(){
        return $this->category_name;
    }

    public function getSellerName(){
        return $this->seller_name;
    }

    public function getInventory(){
        return $this->inventory;
    }

    public function getInventoryAmountType(){
        return $this->inventoryAmountType;
    }
}