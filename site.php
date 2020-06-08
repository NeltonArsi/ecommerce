<?php

use \Hcode\Model\Cart;
use \Hcode\Model\Category;
use \Hcode\Model\Product;
use \Hcode\Page;

$app->get('/', function () {

	$products = Product::listAll();
	$page = new Page();
	$page->setTpl("index", [
		'products' => Product::checkList($products),
	]);

});

$app->get("/site/categories/:idcategory", function ($idcategory) {

	$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
	$category = new Category();
	$category->get((int) $idcategory);

	$pagination = $category->getProductsPage($page);

	$pages = [];
	for ($i = 1; $i <= $pagination['pages']; $i++) {
		array_push($pages, [
			'link' => '/site/categories/' . $category->getidcategory() . '?page=' . $i,
			'page' => $i,
		]);
	}

	$page = new Page();
	$page->setTpl("category", [
		'category' => $category->getValues(),
		'products' => $pagination["data"],
		'pages' => $pages,
	]);

});

$app->get("/site/products/:desurl", function ($desurl) {

	$product = new Product();
	$product->getFromURL($desurl);
	$page = new Page();
	$page->setTpl("product-detail", [
		'product' => $product->getValues(),
		'categories' => $product->getCategories(),
	]);

});

$app->get("/site/cart", function () {

	$cart = Cart::getFromSession();
	$page = new Page();
	$page->setTpl("cart", [
		'cart' => $cart->getValues(),
		'products' => $cart->getProducts(),
		'error' => Cart::getMsgError(),
	]);

});

$app->get("/site/cart/:idproduct/add", function ($idproduct) {

	$product = new Product();
	$product->get((int) $idproduct);
	$cart = Cart::getFromSession();
	$qtd = (isset($_GET['qtd'])) ? (int) $_GET['qtd'] : 1;
	for ($i = 0; $i < $qtd; $i++) {
		$cart->addProduct($product);
	}
	header("Location: /site/cart");
	exit;

});

$app->get("/site/cart/:idproduct/minus", function ($idproduct) {

	$product = new Product();
	$product->get((int) $idproduct);
	$cart = Cart::getFromSession();
	$cart->removeProduct($product);

	header("Location: /site/cart");
	exit;

});

$app->get("/site/cart/:idproduct/remove", function ($idproduct) {

	$product = new Product();
	$product->get((int) $idproduct);
	$cart = Cart::getFromSession();
	$cart->removeProduct($product, true);

	header("Location: /site/cart");
	exit;

});

$app->post("/site/cart/freight", function () {

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /site/cart");
	exit;

});

?>