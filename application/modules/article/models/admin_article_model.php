<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 09.06.12
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
class Admin_Article_Model extends CI_Model {

    /**
     * @var string Основная таблица модуля
     */
    private $_table = 'articles';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Получить страницы по заданным условиям
     * @param int $limit Кол-во страниц
     * @param int $offset
     * @param array $params Дополнительные параметры
     * @return array|null
     */
    public function getList($limit, $offset, $params = array())
    {
        $where = array();
        $result = $this->db
            ->select('p.*, ua.path, ua.auto, ua.alias')
            ->from($this->_table . ' p')
            ->join('url_aliases ua', 'p.alias_id = ua.id')
            ->where($where)
            ->order_by('p.created_date')
            ->limit($limit, $offset)
            ->get()->result_array();

        return $result;
    }

    /**
     * Получить кол-во всех страниц
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all($this->_table);
    }

    /**
     * Получить данные страницы
     * @param int $id
     * @return array
     */
    public function get($id = 0)
    {
        $result = $this->db->get_where($this->_table, array('id' => $id))->row_array();
        return $result;
    }

    /**
     * Создать статью
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        // Метатеги
        $this->load->model('metatags/metatags_model');
        $data['article']['meta_id'] = $this->metatags_model->create($data['meta']);

        $data['article']['created_date'] = time();
        $data['article']['author_id'] = $this->auth->user()->id;

        $data['article']['status'] = isset($data['article']['status']) ? 1 : 0;
        $data['article']['sticky'] = isset($data['article']['sticky']) ? 1 : 0;
        $this->db->insert($this->_table, $data['article']);
        $article_id = $this->db->insert_id();

        // Синоним
        if (isset($data['path']['auto']) && $data['path']['auto'])
        {
            $data['path']['alias'] = 'article/' . $data['article']['title'];
        }
        $data['path']['path'] = 'article/view/' . $article_id;
        $alias_id = $this->path_lib->create($data['path']);

        $this->db->update($this->_table, array('alias_id' => $alias_id), array('id' => $article_id));
    }

    /**
     * Обновить статью
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        // Метатеги
        $this->load->model('metatags/metatags_model');
        $this->metatags_model->update($data['meta_id'], $data['meta']);

        // Синоним
        if (isset($data['path']['auto']) && $data['path']['auto'])
        {
            $data['path']['alias'] = 'article/' . $data['article']['title'];
        }
        $this->path_lib->update($data['alias_id'], $data['path']);

        $data['article']['status'] = isset($data['article']['status']) ? 1 : 0;
        $data['article']['sticky'] = isset($data['article']['sticky']) ? 1 : 0;

        return $this->db->update($this->_table, $data['article'], array('id' => $id)) ? TRUE : FALSE;
    }

    /**
     * Удалить страницу
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function delete($id = 0, $data)
    {
        if ($this->db->delete($this->_table, array('id' => $id)))
        {
            $this->load->model('metatags/metatags_model');
            $this->metatags_model->delete($data['meta_id']);

            $this->path_lib->delete($data['alias_id']);
            return TRUE;
        }
        return FALSE;
    }

    /**             
     * @param array $img
     */
    public function create_images($img)
    {
        $conf = $this->load->config('upload');
        
        // Основные параметры
        $default_config = $conf['image_lib'];
        $origin_img = 'asset/img/article/' . $img['file_name'];

        /** Создание изображения 400x300 */
        $config = array_merge($default_config, array('width' => 400, 'height' => 300));
        $source = $origin_img;
        $new = 'asset/img/article/400x300/' . $img['file_name'];
        $config['source_image'] = $source;
        $config['new_image'] = $new;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        /** Создание превью 120x90 */
        $config = array_merge($default_config, array('width' => 120, 'height' => 90));
        $source = $new;
        $new = 'asset/img/article/120x90/' . $img['file_name'];
        $config['source_image'] = $source;
        $config['new_image'] = $new;
        $this->image_lib->resize_and_crop($config);
    }
}