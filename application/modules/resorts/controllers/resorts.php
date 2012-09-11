<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 30.07.12
 * Time: 08:57
 * To change this template use File | Settings | File Templates.
 */
class Resorts extends MX_Controller {

    public function __construct()
    {
        parent::__construct();

        // Загрузка основной модели
        $this->load->model('resorts/resorts_model');
    }

    /**
     * HTML выпадающий список со списком всех курортов
     * @param array $params
     * @return string html
     */
    public function dropdown($params)
    {
        $resorts = $this->resorts_model->getAll();
        $options = array('' => 'Выберите курорт');
        foreach ($resorts as $resort) {
            $options[$resort['id']] = $resort['name'];
        }
        $extra = '';
        foreach ($params as $attr => $val) {
            if (!in_array($attr, array('name', 'value'))) {
                $extra .= ' ' . $attr . '="' . $val . '"';
            }
        }
        echo form_dropdown($params['name'], $options, $params['value'], $extra);
    }
}