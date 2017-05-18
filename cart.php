<?php

require_once("db/connection.php");

$db = connection([
	"host"     => "localhost:3306",
	"dbname"   => "online_store",
	"user"     => "root",
	"password" => ""
]);

function getCart($db) {
	$sql = "SELECT * FROM cart";
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$productsInCart = [];
	foreach($cart as $product) {
		$fullProduct = getProductById($db, $product['product_id']);
		$fullProduct['quantity'] = $product['quantity'];
		array_push($productsInCart, $fullProduct);
	}

	return $productsInCart;
}

function getProductById($db, $id) {
	$sql = "SELECT * FROM products WHERE id = :id";

	$stmt = $db->prepare($sql);
	$stmt->execute([':id' => $id]);
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

$productsInCart = getCart($db);

$total = 0;

foreach($productsInCart as $product) {
	$total += ($product['price'] * $product['quantity']);
}

$total = ($total * .07) + $total;

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shopping Cart</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css"/>
	</head>

	<body>

		<nav class="navbar">
			<div class="container">
				<a class="navbar-brand" href="/">Your online store</a>
				<div class="navbar-right">
					<div class="container minicart"></div>
				</div>
			</div>
		</nav>

		<div class="container-fluid breadcrumbBox text-center">
			<ol class="breadcrumb">
				<li><a href="#">Review</a></li>
				<li class="active"><a href="#">Order</a></li>
				<li><a href="#">Payment</a></li>
			</ol>
		</div>

		<div class="container text-center">

			<div class="col-md-5 col-sm-12">
				<div class="bigcart"></div> 
				<h1>Your cart</h1>
			</div>

			<div class="col-md-7 col-sm-12 text-left">
				<ul>
					<li class="row list-inline columnCaptions">
						<span>QTY</span>
						<span>ITEM</span>
						<span>Price</span>
					</li>
					<?php foreach($productsInCart as $product): ?>
						<li class="row">
							<span class="quantity"><?php echo $product['quantity']; ?></span>
							<span class="itemName"><?php echo $product['name']; ?></span>
							<span class="popbtn"><a href="/delete.php?id=<?php echo $product['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a></span>
							<span class="price"><?php echo $product['price'] ?></span>
						</li>
					<?php endforeach; ?>
					<li class="row totals">
						<span class="itemName">Total:</span>
						<span class="price">$<?php echo round($total, 2); ?></span>
						<span class="order"> <a class="text-center">ORDER</a></span>
					</li>
				</ul>
			</div>

		</div>

		<!-- JavaScript includes -->

		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/customjs.js"></script>

	</body>
</html>
