<?php

require_once "class.php";

$objTest = new ShoppingCartUnitTest();
$objTest->executeTest01();
$objTest->executeTest02();

foreach ($objTest->errorLog as $message) {
    print $message . "<br>";
}

?>

