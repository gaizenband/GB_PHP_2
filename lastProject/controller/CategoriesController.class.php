<?php

/**
 * Class CategoriesController
 */
class CategoriesController extends Controller
{

    /**
     * @var string директория с шаблонами
     */
    public $view = 'categories';

    /**
     * CategoriesController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->title .= ' - Категории';
    }

    /**
     * @param $data
     * @return array
     * Функция для отрисовки базового шаблона
     */
    public function index($data)
    {
        $categories = Category::getCategories(isset($data['id']) ? $data['id'] : 0);
        $goods = Good::getGoods(isset($data['id']) ? $data['id'] : 0);
        return ['subcategories' => $categories, 'goods' => $goods];
    }

    /**
     * @param $data
     * @return mixed
     * Функция для отрисовки шаблона с товарами
     */
    public function goods($data){
        if($data['id'] > 0){
            $good = new Good([
                "id_good" => $data['id']
            ]);

            return $good->getGoodInfo()[0];
        }
        else{
            header("Location: index.php");
        }


    }
}
?>