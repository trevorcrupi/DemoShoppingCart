<?php

require_once("db/connection.php");

$db = connection([
	"host"     => "localhost:3306",
	"dbname"   => "online_store",
	"user"     => "root",
	"password" => ""
]);
$id = $_GET['id'];

function checkQuantity($db, $id) {
	$stmt = $db->prepare("SELECT * from cart WHERE product_id = :id");
	$stmt->execute([':id' => $id]);
	$product = $stmt->fetch();
	if($product['quantity'] > 1) {
		return $product['quantity'];
	} else {
		return false;
	}
}

$quantityIsGreater1 = checkQuantity($db, $id);

if($quantityIsGreater1) {
	$sql = "UPDATE cart SET quantity = :quantity WHERE product_id = :product_id";
	$stmt = $db->prepare($sql);
	$stmt->execute([':quantity' => $quantityIsGreater1-1, ':product_id' => $id]);
} else {
	$sql = "DELETE FROM cart WHERE product_id = :id";
	$stmt = $db->prepare($sql);
	$stmt->execute([':id' => $id]);
}

header('location: /cart.php');
