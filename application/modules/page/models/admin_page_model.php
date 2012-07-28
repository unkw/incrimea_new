<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 09.06.12
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
class Admin_Page_Model extends CI_Model {

    /**
     * @var string Основная таблица модуля
     */
    private $_table = 'pages';

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
     * Создать страницу
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        // Метатеги
        $this->load->model('metatags/metatags_model');
        $data['page']['meta_id'] = $this->metatags_model->create($data['meta']);

        $data['page']['created_date'] = time();
        $data['page']['author_id'] = $this->auth->user()->id;

        $this->db->insert($this->_table, $data['page']);
        $page_id = $this->db->insert_id();

        // Синоним
        if (isset($data['path']['auto']) && $data['path']['auto'])
        {
            $data['path']['alias'] = $data['page']['title'];
        }
        $data['path']['path'] = 'page/view/' . $page_id;
        $alias_id = $this->path_lib->create($data['path']);

        $this->db->update($this->_table, array('alias_id' => $alias_id), array('id' => $page_id));
    }

    /**
     * Обновить страницу
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
            $data['path']['alias'] = $data['page']['title'];
        }
        $this->path_lib->update($data['alias_id'], $data['path']);

        $where = array('id' => $id);
        return $this->db->update($this->_table, $data['page'], $where) ? TRUE : FALSE;
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
}