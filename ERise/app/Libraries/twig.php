<?php

$date = new Twig\TwigFunction('date', function(){
    return date('Y');
});

$url = new \Twig\TwigFunction('url', function(){
    return URL;
});

$pathcss = new \Twig\TwigFunction('pathcss', function(){
    return PATH_CSS;
});

$pathjs = new \Twig\TwigFunction('pathjs', function(){
    return PATH_JS;
});

$pathimg = new \Twig\TwigFunction('pathimg', function(){
    return PATH_IMG;
});

$basepath = new \Twig\TwigFunction('basepath', function(){
    return BASE_PATH;
});

$urladm = new \Twig\TwigFunction('urladm', function(){
    return BASE_URL_ADMIN;
});

return [
    $date,
    $url,
    $pathcss,
    $pathjs,
    $pathimg,
    $basepath,
    $urladm
];