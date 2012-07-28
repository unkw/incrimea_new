<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 16.06.12
 * Time: 18:02
 * To change this template use File | Settings | File Templates.
 */
class Metatags extends MX_Controller {

   private $meta = array(
       'site' => ' | Incrimea',
       'title' => '',
       'keywords' => '',
       'description' => ''
   );

    public function __construct()
    {
        parent::__construct();

        // Загрузка основной модели
        $this->load->model('metatags/metatags_model');
    }

    /**
     * Отобразить html метатегов в шапке
     */
    public function html()
    {
        echo $this->load->view('head', $this->meta, TRUE);
    }

    public function title()
    {
        echo ($this->meta['title'] ? $this->meta['title'] : $this->base->getTitle()) . $this->meta['site'];
    }

    /**
     * Установить метатеги перед отображением в шаблоне
     * @param int $id
     */
    public function set($id)
    {
        $result = $this->metatags_model->get($id);
        foreach ($result as $name => $content)
        {
            if (isset($this->meta[$name]))
            {
                $this->meta[$name] = $content;
            }
        }
    }

    public function create_form()
    {
        echo $this->load->view('create', array(), TRUE);
    }

    public function edit_form($meta_id)
    {
        $data = $this->metatags_model->get($meta_id);
        $data['meta_id'] = $meta_id;
        echo $this->load->view('edit', $data, TRUE);
    }
}