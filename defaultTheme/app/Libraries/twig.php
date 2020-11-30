<?php

$date = new Twig\TwigFunction('date', function () {
    return date('Y');
});

$url = new \Twig\TwigFunction('url', function () {
    return URL;
});

$pathcss = new \Twig\TwigFunction('pathcss', function () {
    return PATH_CSS;
});

$pathjs = new \Twig\TwigFunction('pathjs', function () {
    return PATH_JS;
});

$pathimg = new \Twig\TwigFunction('pathimg', function () {
    return PATH_IMG;
});

$basepath = new \Twig\TwigFunction('basepath', function () {
    return BASE_PATH;
});

$urladm = new \Twig\TwigFunction('urladm', function () {
    return BASE_URL_ADMIN;
});

$themePath = new \Twig\TwigFunction('themePath', function () {
    return BASE_PATH;
});

$path = new \Twig\TwigFunction('path', function () {
    return PATH;
});

$store = new \Twig\TwigFunction('store', function () {
    $store = new Default_model();
    return $store->getAllInfo();;
});

$categories = new \Twig\TwigFunction('categories', function () {
    $store = new Default_model();
    return $store->getAllCategories();
});

$products = new \Twig\TwigFunction('products', function () {
    $store = new Default_model();
    return $store->getAllproducts();
});

$verifySessionUser = new \Twig\TwigFunction('verifySessionUser', function () {
    $sess = new Session();
    if ($sess->get_userdata('store_user') != NULL) {
        return true;
    } else {
        return false;
    }
});

$getSessionData = new \Twig\TwigFunction('getSessionData', function ($session, $data) {
    $sess = new Session();

    return $sess->get_userdata((string)$session, (string)$data);
});

// $productsCart = new \Twig\TwigFunction('productsCart', function($session, $idprod){
//     $sess = new Session();


// });

$getTotalCart = new \Twig\TwigFunction('getTotalCart', function () {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total = $total + $item['prod_price'];
        }
    }
    return $total;
});



return [
    $date,
    $url,
    $pathcss,
    $pathjs,
    $pathimg,
    $basepath,
    $urladm,
    $themePath,
    $store,
    $categories,
    $path,
    $products,
    $verifySessionUser,
    $getSessionData,
    $getTotalCart
];
