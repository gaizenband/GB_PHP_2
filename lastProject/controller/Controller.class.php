<?php

/**
 * Class Controller базовый класс для контроллеров
 */
class Controller
{
    /**
     * @var string
     */
    public $view = 'admin';
    /**
     * @var mixed
     */
    public $title;

    /**
     * Controller constructor.
     * @throws Exception
     */
    function __construct()
    {
        $this->title = Config::get('sitename');
    }

    /**
     * @param $data
     * @return array
     */
    public function index($data) {
        return [];
    }
}