<?php

$publicKey = "- TO BE GENERATED ON EUROPEX -";
$privateKey = "- TO BE GENERATED ON EUROPEX -";

$ex = new europex($publicKey,$privateKey);

echo "My last orders : " .
$ex->get("order") . "\n";

echo "Make a BTC/Quark sell order 0.03 @ 0.5 BTC per Quark : " .
$ex->post("order/BTC/QRK",array("nature"=>"sell","quantity"=>"156.132144","price"=>"0.5")) . "\n";

$lastOrderQRK = json_decode($ex->get("order/BTC/QRK/0/1"),true);
print_r($lastOrderQRK);

echo "My last Quark order ID : ".
$lastOrderQRK["data"][0]["id"] . "\n";

echo "Cancel this order : " .
$ex->delete("order/".$lastOrderQRK["data"][0]["id"]) . "\n";

echo "Withdraw coins : " .
$ex->post("withdraw/QRK",array("address"=>"ATp9HaJedSN7gFCEJs56444yCL5giDWnNQ","amount"=>0.01337));

echo "Get withdraws :" .
$ex->get("withdraw/QRK")."\n";
