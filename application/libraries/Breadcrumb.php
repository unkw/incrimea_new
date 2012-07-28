<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 16.06.12
 * Time: 0:17
 * To change this template use File | Settings | File Templates.
 */
class Breadcrumb {

    private $CI;
    private $collection = array();
    private $separator = ' » ';

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * Добавить хлебную крошку
     * @param string $title
     * @param string $href
     */
    public function add($title, $href = '')
    {
        $this->collection[] = array(
            'title' => $title,
            'href'  => $href
        );
    }

    /**
     * Отобразить хлебные крошки
     * @param string $separator
     * @return string
     */
    public function display($separator = '')
    {
        $html = array();

        $last = array_pop($this->collection);
        foreach ($this->collection as $bc)
        {
            $html[] = anchor($bc['href'], $bc['title']);
        }
        $html[] = $last['title'];

        return implode($separator ? $separator : $this->separator, $html);
    }
}