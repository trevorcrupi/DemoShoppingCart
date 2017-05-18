<?php

require_once("db/connection.php");

$db = connection([
	"host"     => "localhost:3306",
	"dbname"   => "online_store",
	"user"     => "root",
	"password" => ""
]);
$id = $_GET['id'];

function checkInCart($db, $id) {
	$stmt = $db->prepare("SELECT * from cart WHERE product_id = :id");
	$stmt->execute([':id' => $id]);
	$product = $stmt->fetch();
	if($product['quantity'] !== null) {
		return $product['quantity'];
	} else {
		return false;
	}
}

$itIsInCart = checkInCart($db, $id);

if($itIsInCart) {
	$sql = "UPDATE cart SET quantity = :quantity WHERE product_id = :product_id";
	$stmt = $db->prepare($sql);
	$stmt->execute([':quantity' => $itIsInCart+1, ':product_id' => $id]);
} else {
	$sql = "INSERT INTO cart (product_id, quantity) VALUES (:id, :quantity)";
	$stmt = $db->prepare($sql);
	$stmt->execute([':id' => $id, ':quantity' => $quantity+1]);
}

header('location: /cart.php');
