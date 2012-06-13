<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Admin_Menu extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Проверка прав доступа
        $this->_checkAccess();

        // Загрузка библиотек
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->CI =& $this;

        // Загрузка основной модели
        $this->load->model('menu/admin_menu_model');
    }

    /**
     * Проверка доступа
     * @return bool
     */
    private function _checkAccess()
    {
        if ($this->auth->isLogged())
        {
            $user = $this->auth->user();
            if ($user->role == 'admin')
            {
                return TRUE;
            }
            show_404();
        }
        redirect('user/login');
    }

    /**
     * Список пунктов меню
     * @param string $menu_name
     */
    public function indexAction($menu_name)
    {
        $data = array();
        $data['menu_name'] = $menu_name;
        $data['items'] = $this->admin_menu_model->getItems($menu_name);

        $this->base->setTitle($menu_name);
        $this->base->setContent($this->load->view('menu/admin_item_list.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Список меню
     */
    public function listAction()
    {
        $this->load->library('pagination');

        // Настройки пагинации
        $config['base_url'] = base_url() . 'admin/menu/list';
        $config['total_rows'] = $this->admin_menu_model->count_all();
        $config['per_page'] = 20;
        $config['first_url'] = base_url() . 'admin/menu/list';
        $config['uri_segment'] = 4;

        // Инициализация пейджера
        $this->pagination->initialize($config);

        // Номер страницы
        $page = (int)$this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $config['per_page'];

        if ($offset > $config['total_rows'])
            show_404();

        $data = array();
        $data['pager'] = $this->pagination->create_links();
        $data['menu'] = $this->admin_menu_model->getList($config['per_page'], $offset);

        $this->base->setTitle('Список меню');
        $this->base->setContent($this->load->view('menu/admin_list.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Создание нового меню
     */
    public function createAction()
    {
        if ($this->form_validation->run('create'))
        {
            $this->admin_menu_model->create($this->input->post('menu'));

            $this->message->set('success', 'Создание меню прошло успешно');

            redirect('admin/menu/list');
        }

        $data = array();
        $data['menu'] = array(
            'id'    => '',
            'title' => '',
            'name'  => '',
            'desc'  => '',
        );

        $this->base->setTitle('Создание меню');
        $this->base->setContent($this->load->view('menu/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Редактирование меню
     * @param int $id
     */
    public function editAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->form_validation->run('edit'))
        {
            $this->admin_menu_model->update($id, $this->input->post('menu'));

            $this->message->set('success', 'Изменения сохранены успешно');

            redirect('admin/menu/list');
        }

        $data = array();
        $data['menu'] = $this->admin_menu_model->get($id);

        $this->base->setTitle('Редактирование меню');
        $this->base->setContent($this->load->view('menu/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Удаление меню
     * @param int $id
     */
    public function deleteAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->input->post('id') && $this->input->post('id') != 1)
        {
            $this->admin_menu_model->delete($this->input->post('id'));

            $this->message->set('success', 'Удаление меню прошло успешно');

            redirect('admin/menu/list');
        }

        $data = array();
        $data['menu'] = $this->admin_menu_model->get($id);

        $this->base->setTitle('Удаление меню');
        $this->base->setContent($this->load->view('menu/delete.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Проверка вводимого имени на уникальность
     * @param string $name
     * @return bool
     */
    public function check_name($name)
    {
        $id = (int) $this->input->post('id');

        if ($this->admin_menu_model->isUnique($id, $name, 'name'))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_name', 'Такое имя уже существует');
            return FALSE;
        }
    }

    /**
     * Добавить пункт меню
     * @param string $menu_name
     */
    public function addItemAction($menu_name)
    {
        if ($this->form_validation->run('add_item'))
        {
            if ($this->admin_menu_model->addItem($menu_name, $this->input->post('item')))
            {
                $this->message->set('success', 'Пункт меню успешно добавлен');
                redirect(current_url(), 'refresh');
            }
            else
            {
                $this->message->set('error', 'Ошибка! Меню '.$menu_name.' не существует');
                redirect(current_url());
            }
        }

        $data = array();
        $data['item'] = array(
            'id'   => '',
            'name' => '',
            'href' => '',
            'title' => '',
            'parent_id' => 0,
            'active' => 1,
        );
        $data['items'] = $this->admin_menu_model->getItems($menu_name);

        $this->base->setTitle('Добавить пункт меню');
        $this->base->setContent($this->load->view('menu/edit_item.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Редакитровать пункт меню
     * @param int $id
     */
    public function editItemAction($id)
    {
        $data = array();
        $data['item'] = $this->admin_menu_model->getItem($id);
        $menu_name = $data['item']['menu_name'];

        if ($this->form_validation->run('edit_item'))
        {
            if ($this->admin_menu_model->updateItem($id, $this->input->post('item'), $data['item']))
            {
                $this->message->set('success', 'Пункт меню успешно обновлен');
                redirect('admin/menu/'.$menu_name.'/items');
            }
            else
            {
                $this->message->set('error', 'Ошибка! Меню '.$menu_name.' не существует');
                redirect(current_url());
            }
        }

        $data['items'] = $this->admin_menu_model->getItems($menu_name);

        $this->base->setTitle('Изменить пункт меню');
        $this->base->setContent($this->load->view('menu/edit_item.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Удалить пункт меню
     * @param int $id
     */
    public function deleteItemAction($id)
    {
        $data = array();
        $data['item'] = $this->admin_menu_model->getItem($id);
        $menu_name = $data['item']['menu_name'];

        if ($this->input->post('id'))
        {
            $this->admin_menu_model->deleteItem($this->input->post('id'), $data['item']);

            $this->message->set('success', 'Пункт меню успешно удален');

            redirect('admin/menu/'.$menu_name.'/items');
        }

        $this->base->setTitle('Удалить пункт меню');
        $this->base->setContent($this->load->view('menu/delete_item.php', $data, TRUE));
        $this->base->render();
    }

}