<?php
include_once "GetImages.php";
include 'vendor/twig/twig/lib/twig/Autoloader.php';
Twig_Autoloader::register();

try{
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('list.tmpl');
    $main = $twig->loadTemplate('main.tmpl');

    $content = $template->render(["contents"=>$img_array]);
    $page = $main->render(["content"=>$content]);
    echo html_entity_decode($page);

}catch(Exception $e){
    echo $e;
}