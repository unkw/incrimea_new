<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Article extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Загрузка основной модели
        $this->load->model('article/article_model');
    }

    public function viewAction($id=0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        $data = $this->article_model->get($id);
        if (!$data)
            show_404();

        Modules::run('metatags/setById', $data['meta_id']);

        $this->base->setTitle($data['title']);
        $this->base->setContent($this->load->view('article/object.php', $data, TRUE));
        $this->base->render();
    }

}