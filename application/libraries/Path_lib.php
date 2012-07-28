<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 16.06.12
 * Time: 10:43
 * To change this template use File | Settings | File Templates.
 */
class Path_lib {

    private $CI,
            $_table = 'url_aliases';

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    public function identity()
    {
    }

    public function create_form()
    {
        return $this->CI->load->view('path/edit', array(), TRUE);
    }

    public function edit_form($alias_id)
    {
        $data = $this->CI->db->get_where($this->_table, array('id' => $alias_id))->row_array();
        return $this->CI->load->view('path/edit', $data, TRUE);
    }

    /**
     * Создать синоним
     * @param $data array
     * @return int
     */
    public function create($data)
    {
        $data['alias'] = $this->convert_alias($data['alias']);
        $data['alias'] = $this->check_duplicate_alias($data['alias']);

        $data['auto'] = isset($data['auto']) ? $data['auto'] : 0;

        $this->CI->db->insert($this->_table, $data);
        return $this->CI->db->insert_id();
    }

    /**
     * Обновить синоним
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $data['alias'] = $this->convert_alias($data['alias']);
        $data['alias'] = $this->check_duplicate_alias($data['alias'], $id);

        $data['auto'] = isset($data['auto']) ? $data['auto'] : 0;

        return $this->CI->db->update($this->_table, $data, array('id' => $id));
    }

    public function delete($id)
    {
        return $this->CI->db->delete($this->_table, array('id' => $id));
    }

    /**
     * Преобразование синонима к валидному формату
     * @param string $alias
     * @return string
     */
    private function convert_alias($alias)
    {
        $parts = explode('/', $alias);
        $valid = array();

        $this->CI->load->helper('text');
        foreach ($parts as $part) {
            $valid[] = url_title(convert_accented_characters($part), 'dash', TRUE);
        }

        return implode(',', $valid);
    }

    /**
     * Проверка существует ли такой же синоним
     * @param string $alias
     * @param int $id
     * @return string
     */
    private function check_duplicate_alias($alias, $id = 0)
    {
        $unique = $alias;
        $suffix = 2;

        while ( $this->CI->db->get_where($this->_table, array('alias' => $unique, 'id <>' => $id))->row() )
        {
            $unique = $alias . '-' . $suffix;
            $suffix++;
        }

        return $unique;
    }
}