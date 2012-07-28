<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Page extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Загрузка основной модели
        $this->load->model('page/page_model');
    }

    public function viewAction($id=0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        $data = $this->page_model->get($id);
        if (!$data)
            show_404();

        Modules::run('metatags/set', $data['meta_id']);

        $this->base->setTitle($data['title']);
        $this->base->setContent($this->load->view('page/page.php', $data, TRUE));
        $this->base->render();
    }

}