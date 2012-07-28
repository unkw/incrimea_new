<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Admin_Page extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Проверка прав доступа
        $this->_checkAccess();

        // Загрузка библиотек
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->form_validation->CI =& $this;

        // Хлебная крошка
        $this->breadcrumb->add('Страницы', 'admin/page/list');

        // Загрузка основной модели
        $this->load->model('page/admin_page_model');
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
     * Список страниц
     */
    public function listAction()
    {
        $this->load->library('pagination');

        // Настройки пагинации
        $config['base_url'] = base_url() . 'admin/page/list';
        $config['total_rows'] = $this->admin_page_model->count_all();
        $config['per_page'] = 20;
        $config['first_url'] = base_url() . 'admin/page/list';
        $config['uri_segment'] = 4;

        // Инициализация пейджера
        $this->pagination->initialize($config);

        // Номер страницы
        $page = (int)$this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $config['per_page'];

        if ($offset > $config['total_rows'])
            show_404();

        $this->tabs->add('Создать', 'admin/page/create');

        $data = array();
        $data['pager'] = $this->pagination->create_links();
        $data['pages'] = $this->admin_page_model->getList($config['per_page'], $offset);

        $this->base->setTitle('Список страниц');
        $this->base->setContent($this->load->view('page/admin_list.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Создание страницы
     */
    public function createAction()
    {
        if ($this->form_validation->run('create'))
        {
            $this->admin_page_model->create($this->input->post());

            $this->message->set('success', 'Создание страницы прошло успешно');

            redirect('admin/page/list');
        }

        $this->breadcrumb->add('Создать');

        $data = array();

        $this->base->ckeditor_init();
        $this->base->setTitle('Создание страницы');
        $this->base->setContent($this->load->view('page/create.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Редактирование страницы
     * @param int $id
     */
    public function editAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->form_validation->run('edit'))
        {
            $this->admin_page_model->update($id, $this->input->post());

            $this->message->set('success', 'Изменения сохранены успешно');

            redirect('admin/page/list');
        }

        $this->breadcrumb->add('Редактирование');

        $data = array();
        $data['page'] = $this->admin_page_model->get($id);

        $this->base->ckeditor_init();
        $this->base->setTitle('Редактирование страницы');
        $this->base->setContent($this->load->view('page/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Удаление страницы
     * @param int $id
     */
    public function deleteAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        $data = array();
        $data['page'] = $this->admin_page_model->get($id);

        if ($this->input->post('id'))
        {
            $this->admin_page_model->delete($this->input->post('id'), $data['page']);

            $this->message->set('success', 'Удаление страницы прошло успешно');

            redirect('admin/page/list');
        }

        $this->breadcrumb->add('Удаление');

        $this->base->setTitle('Удаление страницы');
        $this->base->setContent($this->load->view('page/delete.php', $data, TRUE));
        $this->base->render();
    }

}