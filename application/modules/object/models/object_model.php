<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 28.07.12
 * Time: 17:26
 * To change this template use File | Settings | File Templates.
 */
class Object_Model extends CI_Model {

    private $_table = 'objects',
            $_fields = null;

    public function __construct() {
        parent::__construct();
    }

    public function get($id)
    {
        $result = $this->db->get_where($this->_table, array('id' => $id))->row_array();
        return $result;
    }


    public function getField($cat_id)
    {
        if (is_null($this->_fields))
        {
            $fields = $this->db->get('obj_fields')->result_array();
            foreach ($fields as $field)
            {
                if ( ! isset($this->_fields[$field['cat_id']]) )
                {
                    $this->_fields[$field['cat_id']] = array();
                }
                $this->_fields[$field['cat_id']][] = $field;
            }
        }
        return $this->_fields[$cat_id];
    }

    public function in_room()
    {
        return $this->getField(1);
    }

    public function infrastructure()
    {
        return $this->getField(2);
    }

    public function entertainment()
    {
        return $this->getField(3);
    }

    public function service()
    {
        return $this->getField(4);
    }

    public function for_child()
    {
        return $this->getField(5);
    }



}