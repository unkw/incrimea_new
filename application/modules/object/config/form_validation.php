<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array();

// Создание
$config['create'] = array(
    array(
        'field' => 'object[title]',
        'label' => 'Заголовок',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[admin_info]',
        'label' => 'Информация для администрации',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[short_info]',
        'label' => 'Краткая информация',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[type_id]',
        'label' => 'Тип объекта',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[price]',
        'label' => 'Цены',
        'rules' => 'required|is_numeric'
    ),
    array(
        'field' => 'object[food]',
        'label' => 'Питание',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[beach_id]',
        'label' => 'Тип пляжа',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[beach_distance_id]',
        'label' => 'Расстояние до пляжа',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[priority]',
        'label' => 'Приоритет',
        'rules' => ''
    ),
    array(
        'field' => 'object[status]',
        'label' => 'Статус',
        'rules' => ''
    ),
    array(
        'field' => 'object[sticky]',
        'label' => 'Закреплять вверху списка',
        'rules' => ''
    ),
    array(
        'field' => 'object[body]',
        'label' => 'Основное описание',
        'rules' => 'required'
    ),
    // Metatags
    array(
        'field' => 'meta[title]',
        'label' => 'Заголовок',
        'rules' => ''
    ),
    array(
        'field' => 'meta[keywords]',
        'label' => 'Ключевые слова',
        'rules' => ''
    ),
    array(
        'field' => 'meta[description]',
        'label' => 'Описание',
        'rules' => ''
    ),
    // Path
    array(
        'field' => 'path[auto]',
        'label' => '',
        'rules' => ''
    ),
    array(
        'field' => 'path[alias]',
        'label' => 'Синоним',
        'rules' => ''
    ),
    // Resorts
    array(
        'field' => 'object[resort_id]',
        'label' => 'Курорт',
        'rules' => 'required'
    ),
    // Images
    array(
        'field' => 'object[img]',
        'label' => 'Галерея',
        'rules' => 'required'
    ),
    array(
        'field' => 'object[in_room]',
        'label' => 'В номере',
        'rules' => ''
    ),
);
// Редактирование
$config['edit'] = array_merge($config['create'], array(

));
