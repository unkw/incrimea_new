<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array();

$config['create'] = array(
    array(
        'field' => 'menu[title]',
        'label' => 'Название',
        'rules' => 'required',
    ),
    array(
        'field' => 'menu[name]',
        'label' => 'Машинное имя',
        'rules' => 'required|alpha_dash|callback_check_name',
    ),
);

$config['edit'] = $config['create'];

$config['add_item'] = array(
    array(
        'field' => 'item[name]',
        'label' => 'Название ссылки',
        'rules' => 'required|min_length[2]',
    ),
    array(
        'field' => 'item[href]',
        'label' => 'Адрес',
        'rules' => 'required',
    ),
    array(
        'field' => 'item[active]',
        'label' => '',
        'rules' => '',
    ),
);

$config['edit_item'] = $config['add_item'];