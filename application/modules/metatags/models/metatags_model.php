<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metatags_model extends CI_Model {

    private $_table = 'metatags';

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        $result = $this->db->get_where($this->_table, array('id' => $id))->row_array();
        return $result;
    }

    /**
     * Создать метатеги
     * @param $data array
     * @return int
     */
    public function create($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    /**
     * Обновить метатеги
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->db->update($this->_table, $data, array('id' => $id));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array('id' => $id));
    }
}