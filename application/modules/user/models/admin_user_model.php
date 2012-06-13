<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 09.06.12
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
class Admin_User_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Получить пользователей по заданным условиям
     * @param int $limit Кол-во пользователей
     * @param int $offset
     * @param array $params Дополнительные параметры
     * @return array|null
     */
    public function getList($limit, $offset, $params = array())
    {
        $result = $this->db
            ->select('u.*, r.name as role')
            ->from('users u')
            ->join('roles r', 'u.role_id=r.id')
            ->limit($limit, $offset)
            ->get()
            ->result_array();

        return $result;
    }

    /**
     * Получить кол-во всех пользователей
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all('users');
    }

    /**
     * Получить данные пользоватлея
     * @param int $id
     * @return array
     */
    public function get($id = 0)
    {
        $result = $this->db->get_where('users', array('id' => $id))->row_array();
        return $result;
    }

    /**
     * Создание нового пользователя
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
     * Обновить данные пользователя
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $where = array('id' => $id);
        return $this->db->update('users', $data, $where) ? TRUE : FALSE;
    }

    /**
     * Удалить пользователя
     * @param int $id
     * @return bool
     */
    public function delete($id = 0)
    {
        // Главного админа удалить нельзя :)
        if ($id == 1)
            return FALSE;

        return $this->db->delete('users', array('id' => $id));
    }

    /**
     * Получить список всех ролей
     * @return array
     */
    public function getRoles()
    {
        $result = $this->db->order_by('id', 'asc')->get('roles')->result_array();
        return $result;
    }

    /**
     * Проверка значения поля на уникальность
     * @param int $id Идентификатор пользователя
     * @param string $value Проверяемое значение
     * @param string $field Название колонки в таблице users
     * @return bool
     */
    public function isUnique($id, $value, $field)
    {
        $result = $this->db->get_where('users', array(
            $field => $value,
            'id !=' => $id
        ))->row();

        return $result ? FALSE : TRUE;
    }

}