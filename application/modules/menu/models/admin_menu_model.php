<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 09.06.12
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
class Admin_Menu_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Получить список меню по заданным условиям
     * @param int $limit Кол-во меню
     * @param int $offset
     * @param array $params Дополнительные параметры
     * @return array|null
     */
    public function getList($limit, $offset, $params = array())
    {
        $result = $this->db
            ->select('*')
            ->from('menu')
            ->limit($limit, $offset)
            ->get()
            ->result_array();

        return $result;
    }

    /**
     * Получить кол-во всех меню
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all('menu');
    }

    /**
     * Получить данные меню
     * @param int $id
     * @return array
     */
    public function get($id = 0)
    {
        $result = $this->db->get_where('menu', array('id' => $id))->row_array();
        return $result;
    }

    /**
     * Создание нового меню
     * @param array $data
     * @return int
     */
    public function create($data)
    {
        $this->db->insert('menu', $data);
        return $this->db->insert_id();
    }

    /**
     * Обновить данные меню
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data)
    {
        $where = array('id' => $id);
        return $this->db->update('menu', $data, $where) ? TRUE : FALSE;
    }

    /**
     * Удалить меню
     * @param int $id
     * @return bool
     */
    public function delete($id = 0)
    {
        // Админ. меню удалять нельзя :)
        if ($id == 1)
            return FALSE;

        return $this->db->delete('menu', array('id' => $id));
    }

    /**
     * Проверка значения поля на уникальность
     * @param int $id Идентификатор меню
     * @param string $value Проверяемое значение
     * @param string $field Название колонки в таблице
     * @return bool
     */
    public function isUnique($id, $value, $field)
    {
        $result = $this->db->get_where('menu', array(
            $field => $value,
            'id !=' => $id
        ))->row();

        return $result ? FALSE : TRUE;
    }

    /**
     * Получить пункты по названию меню
     * @param string $menu_name
     * @return array
     */
    public function getItems($menu_name)
    {
        $result = $this->db
            ->select('i.*')
            ->from('menu m')
            ->join('menu_items i', 'i.menu_id=m.id')
            ->where(array('m.name' => $menu_name))
            ->order_by('i.level, i.parent_id, i.order')
            ->get()
            ->result_array();

        return $result;
    }

    /**
     * Получить пункт меню по его id
     * @param int $id
     * @return array
     */
    public function getItem($id)
    {
        $result = $this->db
            ->select('i.*, m.name as menu_name')
            ->from('menu m')
            ->join('menu_items i', 'i.menu_id=m.id')
            ->where(array('i.id' => $id))
            ->get()->row_array();
        return $result;
    }

    /**
     * Добавить пункт меню
     * @param string $menu_name
     * @param array $data
     * @return int|bool
     */
    public function addItem($menu_name, $data)
    {
        // Меню
        $menu = $this->db->get_where('menu', array('name' => $menu_name))->row_array();
        if (!empty($menu))
        {
            // Определяем уровень вложенности
            $parent = $this->db
                ->select('level')
                ->get_where('menu_items', array('id'=>$data['parent_id'],'menu_id'=>$menu['id']))
                ->row_array();
            $data['level'] = $parent['level'] ? $parent['level']+1 : 1;

            // Определяем порядковый номер
            $max = $this->db
                ->select('max(`order`) as `order`')
                ->get_where('menu_items', array('parent_id'=>$data['parent_id'],'menu_id'=>$menu['id']))
                ->row_array();
            $data['order'] = $max['order'] ? $max['order']+1 : 1;

            // ID Меню
            $data['menu_id'] = $menu['id'];

            $this->db->insert('menu_items', $data);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * Обновить пункт меню
     * @param int $id идентификатор пункта меню
     * @param array $data обновленные данные
     * @param array $old_data данные до обновления
     * @return bool
     */
    public function updateItem($id, $data, $old_data)
    {
        // Если пункт не менял своего родителя
        if ($data['parent_id'] == $old_data['parent_id'])
        {
            $this->db->update('menu_items', $data, array('id' => $id));
        }
        // Пункту меню назначен другой родитель
        else
        {
            // Определяем уровень вложенности
            $parent = $this->db
                ->select('level')
                ->get_where('menu_items', array('id' => $data['parent_id']))
                ->row_array();
            $data['level'] = $parent['level'] ? $parent['level']+1 : 1;

            // Определяем порядковый номер
            $max = $this->db
                ->select('max(`order`) as `order`')
                ->get_where('menu_items', array('parent_id' => $data['parent_id']))
                ->row_array();
            $data['order'] = $max['order'] ? $max['order']+1 : 1;

            // Обновить редактируемый пункт
            $this->db->update('menu_items', $data, array('id' => $id));

            // Обновить порядковый номер у соседей редактируемого пункта в предыдущем родителе
            $this->db->query('
                UPDATE menu_items SET `order`=`order`-1
                WHERE parent_id=? AND `order`>?',
                array($old_data['parent_id'], $old_data['order'])
            );

            // Обновить уровень вложенности у потомков редактируемого пункта
            $child_ids = array($id);
            $level = $data['level'];
            $batches = array();
            do {
                $children = $this->db
                    ->where_in('parent_id', $child_ids)
                    ->get('menu_items')
                    ->result_array();

                $child_ids = array();
                $level++;
                foreach ($children as $child)
                {
                    $child_ids[] = $child['id'];
                    $batches[] = array(
                        'id' => $child['id'],
                        'level' => $level
                    );
                }
            } while (!empty($child_ids));
            $this->db->update_batch('menu_items', $batches, 'id');
        }

        return TRUE;
    }

    /**
     * Удаление пункта меню
     * @param $id
     * @param $data
     * @return bool
     */
    public function deleteItem($id, $data)
    {
        // Удаление текущего пункта и всех его потомков
        $delete_ids = array($id);
        $child_ids = array($id);
        do {
            $children = $this->db
                ->where_in('parent_id', $child_ids)
                ->get('menu_items')
                ->result_array();
            $child_ids = array();
            foreach ($children as $child)
            {
                $child_ids[] = $child['id'];
                $delete_ids[] = $child['id'];
            }

        } while($child_ids);
        $this->db->where_in('id', $delete_ids)->delete('menu_items');

        // Обновить порядковый номер у соседей удаляемого пункта
        $this->db->query('
            UPDATE menu_items SET `order`=`order`-1
            WHERE parent_id=? AND `order`>?',
            array($data['parent_id'], $data['order'])
        );

        return TRUE;
    }
}