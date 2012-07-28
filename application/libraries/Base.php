<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:56
 * To change this template use File | Settings | File Templates.
 */
class Base extends MX_Controller {

    /**
     * @var string Шаблон отображения
     */
    protected $_layout = 'template';
    /**
     * @var array Параметры шаблона
     */
    protected  $_data = array(
        'title' => '',
        'content' => ''
    );

    /**
     * @var bool Флаг - разрешен ли доступ к запрашиваемому действию
     */
    public $accessIsAllowed = true;

    /**
     * @var string Суффикс методов классов
     */
    private $_actionSuffix = 'Action';

    public function __construct()
    {
        parent::__construct();

        // Определение реального пути (если используются синнонимы)
        $this->path_lib->identity();

        // Назначение суффикса методу
        $method = $this->router->fetch_method() . $this->_actionSuffix;
        $this->router->set_method($method);

        // Обновление активности пользователя
        if ($this->session->userdata('last_activity') < time() - 300) {
            $this->session->set_userdata('last_activity', time());
            $this->auth->updateActivity();
        }

        // Если запрашиваемый адрес это страницы админ. панели
        $class = $this->router->fetch_class();
        if (preg_match('/^admin/', $class))
        {
            $this->load->library('tabs');

            $this->setLayout('dashboard');
            $this->breadcrumb->add('Админ. панель', 'admin');
        }

        // Профайлер (Для админов)
        $user = $this->auth->user();
        if ($user && $user->role == 'admin')
            $this->output->enable_profiler(TRUE);
    }

    /**
     * Отобразить шаблон
     */
    public function render()
    {
        $this->load->view('layouts/' . $this->_layout . EXT, $this->_data);
    }

    /**
     * Получить заголовок страницы
     * @return string
     */
    public function getTitle()
    {
        return $this->_data['title'];
    }

    /**
     * Установить заголовок
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_data['title'] = $title;
    }

    /**
     * Установить контент
     * @param string $content
     */
    public function setContent($content)
    {
        $this->_data['content'] = $content;
    }

    /**
     * Установить шаблон
     * @param string $name
     */
    public function setLayout($name)
    {
        $this->_layout = $name;
    }

    public function ckeditor_init()
    {
        $this->load->library('ckeditor');
        $this->ckeditor->basePath = base_url().'asset/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'ru';
        $this->ckeditor->config['height'] = '350';
    }

}