-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 11 2012 г., 11:57
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `incrimea_org`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `alias_id` int(6) NOT NULL,
  `resort_id` int(3) NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  UNIQUE KEY `alias_id` (`alias_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `body`, `created_date`, `last_update`, `status`, `sticky`, `author_id`, `meta_id`, `alias_id`, `resort_id`, `img`) VALUES
(2, 'Морской каякинг. Крым, Балаклава, три дня активного отдыха на море', '<p>Балаклава &ndash; когда-то закрытая и засекреченная бухта на черном море в Крыму. Эта бухта до сих пор хранит&nbsp; тайны и легенды и необыкновенную позитивную энергетику. И все окрестности на берегах Балаклавы скрывают уникальные чудеса природы, которые создают необыкновенное ощущение, когда оказываешься внутри этой горной, зеленой, морской местности. Одним словом, можно назвать те места &ndash; РАЙ. И в тех райских местах, на бесподобных морских берегах, где не каждый сможет оказаться, проходит наш путь в Затерянный мир. И путь этот мы держим, по морю на лодках типа &laquo;каяк&raquo;. От этого произошел термин &laquo;морской каякинг&raquo; &ndash; сплав по морю на лодках.</p>\r\n<p>Подготовка к сплаву по морю особого навыка не требует. Но особую внимательность и самоконтроль над собой необходим. Ведь достаточно создать контроль над своим равновесием и крепко удерживать весло, которым гребешь. В каякинге будет играть определенную роль физическая подготовка самого человека. Ведь грести придется почти десяток километров. Усталость и легкая мышечная боль проявит себя. Здесь главное не паниковать, когда в море каждый находится в равной позиции. И настрой самого себя на продолжение пути &ndash; это контроль своей собственной уверенности. Для тех, кто плавать не умеет, запрета на такие сплавы по морю не должны быть, а должен быть всегда плавательный жилет. Он должен быть хорошо и правильно одет. И тогда поход на каяке пройдет интересно и без происшествий. Главное, что рядом всегда есть участники похода, которые всегда готовы помочь друг другу.</p>\r\n<p>Утренний подъем в гостинице и сбор. Каждый собирает те вещи, которые строго должны быть с собой во время сплава. Отправляемся на катер, который транспортирует всех на дикий морской берег заповедника, протянутый вдоль моря на многие километры. После высадки, несколько километров мы двигаемся пешком, в то место откуда начнется наше великое путешествие по морю на каяках. По другому &ndash; это наш отправочный пункт &ndash; &laquo;стоянка-лагерь&raquo;, где все благоустроенно для проживания и подготовки к сплаву в природных условиях заповедного места на море. Удивительное по красоте местечко.</p>\r\n', 1344120263, 0, 1, 0, 1, 8, 6, 23, 'kayaking.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('d13dfa908a4255bf8fb3a4b1e5b52f9a', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', 1347116674, 'a:2:{s:9:"user_data";s:0:"";s:3:"uid";s:1:"1";}');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` mediumint(2) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL,
  `name` varchar(20) NOT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `title`, `name`, `desc`) VALUES
(1, 'Админ меню', 'admin_menu', 'Административное меню');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `menu_id` mediumint(2) NOT NULL,
  `name` varchar(20) NOT NULL,
  `href` varchar(160) NOT NULL,
  `title` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `order` smallint(2) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `parent_id` int(4) NOT NULL DEFAULT '0',
  `level` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_id` (`menu_id`,`order`,`parent_id`,`level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `name`, `href`, `title`, `active`, `order`, `visible`, `parent_id`, `level`) VALUES
(1, 1, 'Главная', '[front]', '', 1, 1, 0, 0, 1),
(2, 1, 'Отели', 'objects', 'Отели', 1, 2, 0, 0, 1),
(3, 1, 'Статьи', 'articles', '', 1, 3, 0, 0, 1),
(4, 1, 'События', 'events', '', 1, 4, 0, 0, 1),
(5, 1, 'Новости', 'news', '', 1, 5, 0, 0, 1),
(6, 1, 'Контакты', 'contact', '', 1, 6, 0, 0, 1),
(7, 1, 'Ялта', 'objects/yalta', '', 1, 3, 0, 2, 2),
(8, 1, 'Алушта', 'objects/alushta', '', 1, 1, 0, 2, 2),
(9, 1, 'Поповка', 'objects/popovka', '', 1, 2, 0, 2, 2),
(10, 1, 'Севастополь', 'articles/sevastopol', '', 1, 1, 0, 3, 2),
(15, 1, 'Малая Ялта', 'malaya_yalta', '', 1, 2, 0, 7, 3),
(13, 1, 'Крымское море', 'articles/sea', 'Море Крыма', 1, 2, 0, 3, 2),
(14, 1, 'Большая Ялта', 'objects/yalta/big_yalta', '', 1, 1, 0, 7, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `metatags`
--

CREATE TABLE IF NOT EXISTS `metatags` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `path` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `metatags`
--

INSERT INTO `metatags` (`id`, `title`, `keywords`, `description`, `path`) VALUES
(5, 'About us', 'eter tert ert er er er2', 'afsdaf sdfsdfsadfsdfsad sd fsadfs3', ''),
(8, 'Морской каякинг. Крым, Балаклава.', 'Крым, Балаклава, активный отдых', 'Морской каякинг в Балаклаве Крым', '');

-- --------------------------------------------------------

--
-- Структура таблицы `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_info` text NOT NULL,
  `body` text NOT NULL,
  `created_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `alias_id` int(6) NOT NULL,
  `resort_id` int(3) NOT NULL,
  `img` text NOT NULL,
  `food` varchar(255) NOT NULL,
  `price` int(5) NOT NULL,
  `beach_id` tinyint(1) NOT NULL,
  `beach_distance_id` tinyint(1) NOT NULL,
  `type_id` tinyint(1) NOT NULL,
  `admin_info` text NOT NULL,
  `in_room` text NOT NULL,
  `service` text NOT NULL,
  `infr` text NOT NULL,
  `entment` text NOT NULL,
  `for_child` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  UNIQUE KEY `alias_id` (`alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `obj_fields`
--

CREATE TABLE IF NOT EXISTS `obj_fields` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `cat_id` tinyint(1) NOT NULL,
  `name` varchar(25) NOT NULL,
  `url_name` varchar(15) NOT NULL,
  `is_filter` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `obj_fields`
--

INSERT INTO `obj_fields` (`id`, `cat_id`, `name`, `url_name`, `is_filter`) VALUES
(1, 1, 'Кондиционер', 'cond', 1),
(2, 1, 'Отдельный санузел', 'uzel', 1),
(3, 1, 'Фен', 'fen', 1),
(4, 1, 'Телевизор', 'tv', 1),
(5, 1, 'Балкон', 'balcon', 1),
(6, 1, 'Интернет', 'inet', 1),
(7, 1, 'Мини-бар', 'mbar', 1),
(8, 1, 'Кухня', 'kitch', 1),
(9, 1, 'Холодильник', 'hol', 1),
(10, 1, 'Горячая вода', 'water', 1),
(11, 2, 'Парковка', 'park', 1),
(12, 2, 'Камера хранения', 'save', 1),
(13, 2, 'Сейф', 'safe', 1),
(14, 2, 'Прачечная', 'lau', 1),
(15, 2, 'Обмен валюты', 'money', 1),
(16, 2, 'Ресторан', 'rest', 1),
(17, 2, 'Торговый центр', 'centr', 1),
(18, 2, 'Кафе', 'cafe', 1),
(19, 2, 'Парикмахерская', 'hair', 1),
(20, 2, 'Бар', 'bar', 1),
(21, 2, 'Рынок', 'bazar', 1),
(22, 2, 'Интернет-кафе', 'icafe', 1),
(23, 3, 'Развлекательные программы', 'show', 1),
(24, 3, 'Бассейн', 'bas', 1),
(25, 3, 'Тренажерный зал', 'zal', 1),
(26, 3, 'Сауна', 'sauna', 1),
(27, 3, 'Турецкая баня', 'bania', 1),
(28, 3, 'Компьютерные игры', 'games', 1),
(29, 3, 'Джакузи', 'jak', 1),
(30, 3, 'Бильярд', 'bil', 1),
(31, 3, 'Настольный теннис', 'tennis', 1),
(32, 3, 'Дартс', 'darts', 1),
(33, 3, 'Футбольное поле', 'fball', 1),
(34, 3, 'Аквапарк', 'apark', 1),
(35, 3, 'Дискотека', 'disco', 1),
(36, 3, 'Пирс', 'pirs', 1),
(37, 3, 'Кинотеатр', 'kino', 1),
(38, 3, 'Кальян', 'kalian', 1),
(39, 3, 'Беседки', 'bes', 1),
(40, 3, 'Пляжный волейбол', 'vball', 1),
(41, 4, 'Такси', 'taxi', 1),
(42, 4, 'Факс/Ксерокс', 'fax', 1),
(43, 4, 'Доктор', 'doctor', 1),
(44, 4, 'Фотограф', 'photo', 1),
(45, 5, 'Няня', 'nana', 1),
(46, 5, 'Детский бассейн', 'bas', 1),
(47, 5, 'Детская площадка', 'plka', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `obj_fields_rel`
--

CREATE TABLE IF NOT EXISTS `obj_fields_rel` (
  `obj_id` int(5) NOT NULL,
  `field_id` int(7) NOT NULL,
  PRIMARY KEY (`obj_id`,`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_date` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `author_id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `alias_id` int(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `meta_id` (`meta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `body`, `created_date`, `last_update`, `status`, `sticky`, `author_id`, `meta_id`, `alias_id`) VALUES
(2, 'О нас', '<p>Инкримеа - отдых в Крыму! Удобное бронирование номеров</p>\r\n', 1343056758, 0, 1, 0, 1, 5, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `resorts`
--

CREATE TABLE IF NOT EXISTS `resorts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `url_name` varchar(18) NOT NULL,
  `parent_id` int(3) NOT NULL DEFAULT '0',
  `region_id` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_name` (`url_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `resorts`
--

INSERT INTO `resorts` (`id`, `name`, `url_name`, `parent_id`, `region_id`) VALUES
(1, 'Алупка', 'alupka', 0, 0),
(2, 'Алушта', 'alushta', 0, 0),
(3, 'Бахчисарай', 'bahchisaray', 0, 0),
(4, 'Гурзуф', 'gurzuf', 0, 0),
(5, 'Евпатория', 'evpatoriya', 0, 0),
(6, 'Кацивели', 'katsiveli', 0, 0),
(7, 'Керчь', 'kerch', 0, 0),
(8, 'Коктебель', 'koktebel', 0, 0),
(9, 'Ливадия', 'livadia', 0, 0),
(10, 'Мисхор', 'mishor', 0, 0),
(11, 'Новый свет', 'noviy-svet', 0, 0),
(12, 'Партенит', 'partenit', 0, 0),
(13, 'Песчаное', 'peschanoe', 0, 0),
(14, 'Саки', 'saki', 0, 0),
(15, 'Севастополь', 'sevastopol', 0, 0),
(16, 'Симеиз', 'simeiz', 0, 0),
(17, 'Судак', 'sudak', 0, 0),
(18, 'Феодосия', 'feodosia', 0, 0),
(19, 'Фиолент', 'fiolent', 0, 0),
(20, 'Форос', 'foros', 0, 0),
(21, 'Ялта', 'yalta', 0, 0),
(22, 'Береговое', 'beregovoe', 0, 0),
(23, 'Балаклава', 'balaklava', 0, 0),
(24, 'Поповка', 'popovka', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` smallint(6) NOT NULL,
  `name` varchar(15) NOT NULL,
  `desc` varchar(20) NOT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `desc`, `default`) VALUES
(1, 'admin', 'Администратор', 0),
(2, 'editor', 'Редактор', 0),
(3, 'member', 'Зарегистрированный', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `url_aliases`
--

CREATE TABLE IF NOT EXISTS `url_aliases` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `path` varchar(30) NOT NULL,
  `alias` varchar(140) NOT NULL,
  `auto` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `path` (`path`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `url_aliases`
--

INSERT INTO `url_aliases` (`id`, `path`, `alias`, `auto`) VALUES
(3, 'page/view/2', 'about', 0),
(6, 'article/view/2', 'article/morskoy-kayaking-krim-balaklava', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `created_date` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `role_id` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_date`, `last_login`, `active`, `role_id`) VALUES
(1, 'admin', '9c42bfe1c5a04736aaf144509239194aa5d17fe0', 'kem-ua@mail.ru', 1321311632, 1347116674, 1, 1),
(2, 'Girey', '00e75fc6f0cc8fac0df9ecb846be4cfadff58595', 'girey4ik@mail.ru', 1322949523, 1323563193, 1, 1),
(3, 'testuser', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test@mail.ru', 1339362669, NULL, 1, 3),
(5, 'redaktor', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dfg@mail.ru', 1339362805, NULL, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
