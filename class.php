<?php

class User
{
    private $name;
    private $mail;

    function __construct($name, $mail)
    {
        // validate name, mail
        $this->name = $name;
        $this->mail = $mail;
    }
}

class Product
{
    private $name;
    private $price;
    private $productID;

    function __construct($name, $price)
    {
        // validate name, price
        $this->name = $name;
        $this->price = $price;
        $this->productID = $this->setProductID();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getProductID()
    {
        return $this->productID;
    }

    private function setProductID()
    {
        static $id = 0;
        return ++$id;
    }
}

class ShoppingCart
{
    private $user = null;
    private $products = array();
    private $quantities = array();
    private $defaultQty = 1;

    function __construct($user)
    {
        $this->user = $user;
    }

    public function addProduct($productObj)
    {
        $masterKey = $productObj->getName() . "-" . $productObj->getProductID();
        // add product
        if (!$this->products[$masterKey]) {
            $this->products[$masterKey] = $productObj->getPrice();
            $this->quantities[$masterKey] = $this->defaultQty;
        } else {
            $this->quantities[$masterKey]++;
        }
    }

    public function removeProduct($productObj)
    {
        $masterKey = $productObj->getName() . "-" . $productObj->getProductID();
        // remove product
        if ($this->products[$masterKey] && $this->quantities[$masterKey] > $this->defaultQty) {
            $this->quantities[$masterKey]--;
        } else {
            $this->products[$masterKey];
            $this->quantities[$masterKey];
        }
    }

    public function getTotalPrice()
    {
        // return total price
        $totalPrice = 0;
        foreach ($this->products as $masterKey => $productPrice) {
            $totalPrice += ($productPrice * $this->quantities[$masterKey]);
        }
        return "$" . number_format($totalPrice, 2);
    }
}

class PHPUnit
{
    var $errorLog = array();

    public function assertBool($target, $message = "")
    {
        if (!is_bool($target)) {
            $this->errorLog[] = "This test does not pass.";
            return false;
        } else {
            $this->errorLog[] = $message;
            return true;
        }
    }

    public function assertEqual($target, $expect, $message = "")
    {
        if ($target !== $expect) {
            $this->errorLog[] = "This test does not pass.";
            return false;
        } else {
            $this->errorLog[] = $message;
            return true;
        }
    }
}

class ShoppingCartUnitTest extends PHPUnit
{
    public function executeTest01()
    {
        try {
            $objUser = new User("John Doe", "john.doe@example.com");
            $objCart = new ShoppingCart($objUser);
            $apple = new Product("apple", 4.95);
            $orange = new Product("orange", 3.99);
            $objCart->addProduct($apple);
            $objCart->addProduct($apple);
            $objCart->addProduct($orange);
            $this->assertEqual($objCart->getTotalPrice(), "$13.89", "tes01 passed.");
        } catch (Exception $e) {
            $this->errorLog[] = "test01 does not pass.";
        }
    }

    public function executeTest02()
    {
        try {
            $objUser = new User("John Doe", "john.doe@example.com");
            $objCart = new ShoppingCart($objUser);
            $apple = new Product("apple", 4.95);
            $objCart->addProduct($apple);
            $objCart->addProduct($apple);
            $objCart->addProduct($apple);
            $objCart->removeProduct($apple);
            $this->assertEqual($objCart->getTotalPrice(), "$9.90", "tes02 passed.");
        } catch (Exception $e) {
            $this->errorLog[] = "test02 does not pass.";
        }
    }
}

?>

