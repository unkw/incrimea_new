<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resorts_Model extends CI_Model {

    private $_table = 'resorts';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Получить все курорты
     */
    public function getAll($order = 'asc')
    {
        $result = $this->db->order_by('name', $order)->get($this->_table)->result_array();
        return $result;
    }

    public function get($id)
    {
        $result = $this->db->get_where($this->_table, array('id' => $id))->row_array();
        return $result;
    }

    public function create($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->update($this->_table, $data, array('id' => $id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array('id' => $id));
    }

}