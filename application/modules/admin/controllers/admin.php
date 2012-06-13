<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Admin extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_checkAccess();
    }

    public function indexAction()
    {
        $this->base->setContent('This is admin module page');

        $this->base->render();
    }

    private function _checkAccess()
    {
        if ($this->auth->isLogged())
        {
            $user = $this->auth->user();
            if ($user->role == 'admin')
            {
                return TRUE;
            }
        }
        show_404();
    }

}