<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Admin_User extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Проверка прав доступа
        $this->_checkAccess();

        // Загрузка библиотек
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->form_validation->CI =& $this;

        // Хлебная крошка
        $this->breadcrumb->add('Пользователи', 'admin/user/list');

        // Загрузка основной модели
        $this->load->model('user/admin_user_model');
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
     * Список пользователей
     */
    public function listAction()
    {
        $this->load->library('pagination');

        // Настройки пагинации
        $config['base_url'] = base_url() . 'admin/user/list';
        $config['total_rows'] = $this->admin_user_model->count_all();
        $config['per_page'] = 20;
        $config['first_url'] = base_url() . 'admin/user/list';
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
        $data['users'] = $this->admin_user_model->getList($config['per_page'], $offset);

        $this->base->setTitle('Список пользователей');
        $this->base->setContent($this->load->view('user/admin_list.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Создание нового пользователя
     */
    public function createAction()
    {
        if ($this->form_validation->run('create'))
        {
            $userdata = array(
                'username'     => $this->input->post('edit-name'),
                'password'     => sha1($this->input->post('edit-pass')),
                'email'        => $this->input->post('edit-email'),
                'created_date' => time(),
                'active'       => $this->input->post('edit-status'),
                'role_id'      => $this->input->post('edit-role'),
            );

            $this->admin_user_model->create($userdata);

            $this->message->set('success', 'Создание нового пользователя прошло успешно');

            redirect('admin/user/list');
        }

        $data = array();
        $data['user'] = array(
            'id'       => '',
            'email'    => '',
            'username' => '',
            'active'   => TRUE,
            'role_id'  => 3, // Зарегистрированный пользователь
        );
        $data['roles'] = $this->admin_user_model->getRoles();

        // Хлебная крошка
        $this->breadcrumb->add('Создание', current_url());

        $this->base->setTitle('Создание пользователя');
        $this->base->setContent($this->load->view('user/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Редактирование пользователя
     * @param int $id
     */
    public function editAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->form_validation->run('edit'))
        {
            $userdata = array(
                'username'    => $this->input->post('edit-name'),
                'email'       => $this->input->post('edit-email'),
                'active'      => $this->input->post('edit-status'),
                'role_id'     => $this->input->post('edit-role'),
            );

            $this->admin_user_model->update($id, $userdata);

            $this->message->set('success', 'Изменения сохранены успешно');

            redirect('admin/user/list');
        }

        $data = array();
        $data['roles'] = $this->admin_user_model->getRoles();
        $data['user'] = $this->admin_user_model->get($id);

        // Хлебная крошка
        $this->breadcrumb->add('Редактирование', current_url());

        $this->base->setTitle('Редактирование пользователя');
        $this->base->setContent($this->load->view('user/edit.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Удаление пользователя
     * @param int $id
     */
    public function deleteAction($id = 0)
    {
        if (!$id || !is_numeric($id))
            show_404();

        if ($this->input->post('id') && $this->input->post('id') != 1)
        {
            $this->admin_user_model->delete($this->input->post('id'));

            $this->message->set('success', 'Удаление пользователя прошло успешно');

            redirect('admin/user/list');
        }

        $data = array();
        $data['user'] = $this->admin_user_model->get($id);

        // Хлебная крошка
        $this->breadcrumb->add('Удаление', current_url());

        $this->base->setTitle('Удаление пользователя');
        $this->base->setContent($this->load->view('user/delete.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Страница настроек
     */
    public function settingsAction()
    {
        $data = array();

        // Хлебная крошка
        $this->breadcrumb->add('Настройки', current_url());

        $this->base->setTitle('Настройки пользователей');
        $this->base->setContent($this->load->view('user/settings.php', $data, TRUE));
        $this->base->render();
    }

    /**
     * Проверка вводимого имени на уникальность
     * @param string $name
     * @return bool
     */
    public function check_username($name)
    {
        $id = (int) $this->input->post('user-id');

        if ($this->admin_user_model->isUnique($id, $name, 'username'))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_username', 'Такое имя уже существует');
            return FALSE;
        }
    }

    /**
     * Проверка вводимого почтового адреса на уникальность
     * @param string $email
     * @return bool
     */
    public function check_email($email)
    {
        $id = (int) $this->input->post('user-id');

        if ($this->admin_user_model->isUnique($id, $email, 'email'))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('check_email', 'Такой email адрес уже существует');
            return FALSE;
        }
    }
}