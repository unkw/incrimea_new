<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 07.06.12
 * Time: 1:24
 * To change this template use File | Settings | File Templates.
 */
class Simple extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        echo 'This is simple module page';
    }
}