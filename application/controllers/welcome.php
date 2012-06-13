<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Фронт-контроллер
 */
class Welcome extends MX_Controller {

	function __construct()
    {
        parent::__construct();
    }

	/**
     * Главная страница
     */
    public function indexAction()
	{
        $this->base->setTitle('Добро пожаловать на сайт Incrimea');
        $this->base->setContent('Это главная страница');

        $this->base->render();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */