<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 30.08.12
 * Time: 21:37
 *
 * TABLE: obj_fields
 *      cat_id:
 *      1 - типы объектов
 *      2 - пляж: типы
 *      3 - пляж: дистанции
 */
class Admin_Object_Model extends CI_Model {

    /**
     * @var string Основная таблица модуля
     */
    private $_table = 'objects';

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
     * Создать
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        print '<pre>';
        print_r($data);
        print '</pre>';
        die;

        // Метатеги
        $this->load->model('metatags/metatags_model');
        $data['object']['meta_id'] = $this->metatags_model->create($data['meta']);

        $data['object']['created_date'] = time();

        $data['object']['status'] = isset($data['object']['status']) ? 1 : 0;

        $this->db->insert($this->_table, $data['object']);
        $object_id = $this->db->insert_id();

        // Синоним
        if (isset($data['path']['auto']) && $data['path']['auto'])
        {
            $data['path']['alias'] = 'object/' . $data['object']['title'];
        }
        $data['path']['path'] = 'object/view/' . $object_id;
        $alias_id = $this->path_lib->create($data['path']);

        $this->db->update($this->_table, array('alias_id' => $alias_id), array('id' => $object_id));
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
            $data['path']['alias'] = 'object/' . $data['object']['title'];
        }
        $this->path_lib->update($data['alias_id'], $data['path']);

        $data['object']['status'] = isset($data['object']['status']) ? 1 : 0;
        $data['object']['sticky'] = isset($data['object']['sticky']) ? 1 : 0;

        return $this->db->update($this->_table, $data['object'], array('id' => $id)) ? TRUE : FALSE;
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
     * Получить список типов объектов
     * Отели, пансионаты, частный сектор и т.д.
     * @return array
     */
    public function get_types()
    {
        $result = $this->db->get_where('obj_fields', array('cat_id' => 1))->result_array();
        return $result;
    }

    /**
     * @param array $img
     */
    public function create_images($img)
    {
        $conf = $this->load->config('upload');
        
        // Основные параметры
        $default_config = $conf['image_lib'];
        $origin_img = 'asset/img/object/' . $img['file_name'];

        $this->load->library('image_lib');

        /** Создание изображения 640x480 */
        $config = array_merge($default_config, array('width' => 640, 'height' => 480));
        $source = $origin_img;
        $new = 'asset/img/object/640x480/' . $img['file_name'];
        $config['source_image'] = $source;
        $config['new_image'] = $new;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        /** Создание изображения 400x300 */
        $config = array_merge($default_config, array('width' => 400, 'height' => 300));
        $source = $origin_img;
        $new = 'asset/img/object/400x300/' . $img['file_name'];
        $config['source_image'] = $source;
        $config['new_image'] = $new;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        /** Создание превью 120x90 */
        $config = array_merge($default_config, array('width' => 120, 'height' => 90));
        $source = $new;
        $new = 'asset/img/object/120x90/' . $img['file_name'];
        $config['source_image'] = $source;
        $config['new_image'] = $new;
        $this->image_lib->resize_and_crop($config);
    }
}