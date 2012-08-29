<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: Kemal
 * Date: 29.08.12
 * Time: 21:46
 */
class Admin_Object extends MX_Controller {

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
        $this->breadcrumb->add('Отели', 'admin/object/list');

        // Загрузка основной модели
        $this->load->model('object/admin_object_model');
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
        $config['base_url'] = base_url() . 'admin/object/list';
        $config['total_rows'] = $this->admin_object_model->count_all();
        $config['per_page'] = 20;
        $config['first_url'] = base_url() . 'admin/object/list';
        $config['uri_segment'] = 4;

        // Инициализация пейджера
        $this->pagination->initialize($config);

        // Номер страницы
        $page = (int)$this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $config['per_page'];

        if ($offset > $config['total_rows'])
            show_404();

        $this->tabs->add('Создать', 'admin/object/create');

        $data = array();
        $data['pager'] = $this->pagination->create_links();
        $data['pages'] = $this->admin_object_model->getList($config['per_page'], $offset);

        $this->base->setTitle('Список отелей');
        $this->base->setContent($this->load->view('object/admin_list.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Создание
     */
    public function createAction()
    {
        if ($this->form_validation->run('create'))
        {
            $this->admin_object_model->create($this->input->post());

            $this->message->set('success', 'Создание статьи прошло успешно');

            redirect('admin/object/list');
        }

        $this->breadcrumb->add('Создать');

        $data = array();

        $this->base->ckeditor_init();
        $this->base->setTitle('Создание статьи');
        $this->base->setContent($this->load->view('object/create.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Редактирование
     * @param int $id
     */
    public function editAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->form_validation->run('edit'))
        {
            $this->admin_object_model->update($id, $this->input->post());

            $this->message->set('success', 'Изменения сохранены успешно');

            redirect('admin/object/list');
        }

        $this->breadcrumb->add('Редактирование');

        $data = array();
        $data['object'] = $this->admin_object_model->get($id);

        $this->base->ckeditor_init();
        $this->base->setTitle('Редактирование статьи');
        $this->base->setContent($this->load->view('object/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Удаление
     * @param int $id
     */
    public function deleteAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        $data = array();
        $data['object'] = $this->admin_object_model->get($id);

        if ($this->input->post('id'))
        {
            $this->admin_object_model->delete($this->input->post('id'), $data['object']);

            $this->message->set('success', 'Удаление статьи прошло успешно');

            redirect('admin/object/list');
        }

        $this->breadcrumb->add('Удаление');

        $this->base->setTitle('Удаление статьи');
        $this->base->setContent($this->load->view('object/delete.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Загрузка изображения
     */
    public function uploadAction()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $config = $this->load->config('upload');
        $this->load->library('upload', $config['options']);

        if (!$this->upload->do_upload('images')) {
            echo 'error ' . $this->upload->display_errors('', '');
        }
        else
        {
            $img = $this->upload->data();
            $this->admin_object_model->create_images($img);
            echo $img['file_name'];
        }
    }    

}