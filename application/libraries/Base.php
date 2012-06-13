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
    protected $_data = array(
        'head_title' => 'Incrimea',
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
            $this->setLayout('dashboard');
        }

        // Профайлер (Для режима разработки)
        if (ENVIRONMENT == 'development')
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

}