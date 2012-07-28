<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array();

// Создание
$config['create'] = array(
    array(
        'field' => 'page[title]',
        'label' => 'Заголовок',
        'rules' => 'required'
    ),
    array(
        'field' => 'page[body]',
        'label' => 'Текст страницы',
        'rules' => 'required'
    ),
    array(
        'field' => 'page[status]',
        'label' => 'Статус',
        'rules' => ''
    ),
    array(
        'field' => 'page[sticky]',
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
);
// Редактирование
$config['edit'] = array_merge($config['create'], array(

));
