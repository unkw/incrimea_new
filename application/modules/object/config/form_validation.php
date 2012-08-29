<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array();

// Создание
$config['create'] = array(
    array(
        'field' => 'article[title]',
        'label' => 'Заголовок',
        'rules' => 'required'
    ),
    array(
        'field' => 'article[body]',
        'label' => 'Текст страницы',
        'rules' => 'required'
    ),
    array(
        'field' => 'article[status]',
        'label' => 'Статус',
        'rules' => ''
    ),
    array(
        'field' => 'article[sticky]',
        'label' => 'Закреплять вверху списка',
        'rules' => ''
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
        'field' => 'article[resort_id]',
        'label' => 'Курорт',
        'rules' => 'required'
    ),
    // Images
    array(
        'field' => 'article[img]',
        'label' => 'Титульное изображение',
        'rules' => 'required'
    ), 
);
// Редактирование
$config['edit'] = array_merge($config['create'], array(

));
