<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php print $title . ' | Incrimea.org'; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <link rel="stylesheet" href="<?php print base_url(); ?>css/admin/styles.css" type="text/css" media="screen, projection" />
    <link href='http://fonts.googleapis.com/css?family=Andika&subset=latin,cyrillic' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="<?php print base_url(); ?>css/admin/jquery-ui.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php print base_url(); ?>css/admin/tabs.css" type="text/css" media="screen, projection" />

    <!-- Libraries -->
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/libs/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/libs/jquery-ui.js"></script>

    <!-- Debug mode -->
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/debug.js"></script>

    <!-- Application core  -->
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/App.js"></script>

    <!-- Plugins -->
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/plugins/utils/uploader.js"></script>
    
    <!-- Modules -->
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/modules/loader/tpl.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/modules/admin/alias.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/js/modules/admin/upload.js"></script>

</head>
<body>

<div id="container">

    <ul id="nav">
        <li class="current"><a href="<?php print base_url(); ?>admin">Админ. панель</a></li>
        <li><a href="<?php print base_url(); ?>admin/menu/list">Меню</a></li>
        <li><a href="#">Контент</a>
            <ul>
                <li><a href="<?php print base_url(); ?>admin/page/list">Страницы</a></li>
                <li><a href="<?php print base_url(); ?>admin/article/list">Статьи</a></li>
                <li><a href="<?php print base_url(); ?>admin/event/list">События</a></li>
                <li><a href="<?php print base_url(); ?>admin/object/list">Объекты</a></li>
            </ul>
            </li>
            <li><a href="#">Модули</a>
                <ul>
                    <li><a href="#">Алиасы</a></li>
                    <li><a href="<?php print base_url(); ?>admin/metatags">Метатеги</a></li>
                    <li><a href="#">Фильтры</a></li>
                </ul>
            </li>
            <li><a href="<?php print base_url(); ?>admin/user/list">Пользователи</a>
                <ul>
                    <li><a href="<?php print base_url(); ?>admin/user/list">Список</a></li>
                    <li><a href="<?php print base_url(); ?>admin/user/create">Добавить</a></li>
                    <li><a href="<?php print base_url(); ?>admin/user/settings">Настройки</a></li>
                </ul>
            </li>
            <li><a href="<?php print base_url(); ?>admin/admin/site_settings">Настройка сайта</a></li>
            <li><a href="#">Отчеты</a></li>
    </ul>

    <div id="content">

        <div id="breadcrumb">
            <?php print $this->breadcrumb->display(); ?>
        </div>

        <?php echo $this->message->display(); ?>

        <h1><?php print $title; ?></h1>

        <?php echo $this->tabs->display(); ?>

        <?php print $content; ?>

    </div>

</div>

</body>
</html>