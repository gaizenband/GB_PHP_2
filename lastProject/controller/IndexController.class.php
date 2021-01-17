<?php

class IndexController extends Controller
{
    public $view = 'index';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' | ДЕМО!!!';
    }
	
	//метод, который отправляет в представление информацию в виде переменной content_data
	function index($data){
        $goods = new Good();

		 return ['goods' => $goods->getNewGoods()];
	}
}

//site/index.php?path=index/test/5