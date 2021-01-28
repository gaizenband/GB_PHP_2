<?php

/**
 * Class IndexController контроллер для домашней страницы
 */
class IndexController extends Controller
{
    /**
     * @var string директория с шаблонами
     */
    public $view = 'index';

    /**
     * IndexController constructor.
     * @throws Exception
     */
    function __construct()
    {
        parent::__construct();
        $this->title .= ' - Homepage';
    }

    /**
     * @param $data
     * @return array
     * Метод, который отправляет в представление информацию в виде переменной content_data
     */
	function index($data){
        $goods = new Good();

		 return ['goods' => $goods->getNewGoods()];
	}
}