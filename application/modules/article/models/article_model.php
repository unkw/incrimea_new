<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 28.07.12
 * Time: 17:26
 * To change this template use File | Settings | File Templates.
 */
class Article_Model extends CI_Model {

    private $_table = 'articles';

    public function __construct() {
        parent::__construct();
    }

    public function get($id)
    {
        $result = $this->db->get_where($this->_table, array('id' => $id))->row_array();
        return $result;
    }

}