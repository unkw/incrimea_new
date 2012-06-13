<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class User extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Профиль
     */
    public function profileAction()
    {
        if (!$this->auth->isLogged())
            show_404();

        $user = $this->auth->user();

        $this->base->setTitle('Профиль пользователя');
        $this->base->setContent($this->load->view('user/profile.php', array('user' => $user), TRUE));
        $this->base->render();
    }

    /**
     * Страница авторизации
     */
    public function loginAction()
    {
        if ($this->auth->isLogged())
            show_404();

        $this->load->library('form_validation');

        $config = array(
            array(
                'field' => 'login',
                'label' => 'Логин',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'Пароль',
                'rules' => 'required'
            ),
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run())
        {
            if ($this->auth->login($this->input->post('login'), $this->input->post('password')))
            {
                $this->message->set('success', 'Вход выполнен успешно');
                redirect('/user/profile');
            }
            else
            {
                $this->message->set('error', 'Логин или пароль введены неверно');
            }
        }

        $this->base->setTitle('Вход');
        $this->base->setContent($this->load->view('user/login.php', array(), TRUE));
        $this->base->render();
    }

    /**
     * Разлогинивание
     */
    public function logoutAction()
    {
        if ($this->auth->isLogged())
            $this->auth->logout();
        else
            show_404();

        redirect('/user/login');
    }

    /**
     * ВИДЖЕТ "Меню пользователя"
     */
    public function UserBlock()
    {
        $this->load->view('user/user_block.php');
    }

}