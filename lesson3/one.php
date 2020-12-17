<?php
include 'vendor/twig/twig/lib/twig/Autoloader.php';
Twig_Autoloader::register();

try{
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);
    $template = $twig->loadTemplate('big.tmpl');
    $main = $twig->loadTemplate('main.tmpl');

    $content = $template->render(["contents"=>$_GET['img']]);
    $x = $main->render(["content"=>$content]);
    echo html_entity_decode($x);

}catch(Exception $e){
    echo $e;
}