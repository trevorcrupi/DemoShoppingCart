<?php

require_once("db/connection.php");

$db = connection([
	"host"     => "localhost:3306",
	"dbname"   => "online_store",
	"user"     => "root",
	"password" => ""
]);

function getProducts($db) {
	$sql = "SELECT * FROM products";

	$stmt = $db->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$products = getProducts($db);

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
				<li><a href="#">Our Shop</a></li>
			</ol>
		</div>

		<div class="container text-center">

			<div class="col-md-5 col-sm-12">
				<?php foreach($products as $product): ?>
					<h1><?php echo $product['name']; ?></h1>
					<p><b><?php echo $product['price'] ?></b></p>
					<p><?php echo $product['description']; ?></p>
 				  <a href="insert.php?id=<?php echo $product['id']; ?>">Buy</a>
				<?php endforeach; ?>
			</div>

		</div>
		<!-- JavaScript includes -->

		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/customjs.js"></script>

	</body>
</html>
