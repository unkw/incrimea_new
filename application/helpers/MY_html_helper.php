<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('array_tree')) {

    /**
     * Преобразование массива в древовидную структуру
     * @param array $items
     *      Каждый элемент данного массива должен содержать значения со следующими ключами:
     *      id - идентификатор элемента
     *      parent_id - id родителя
     *      level - уровень
     * @return array
     */
    function array_tree($items)
    {
        $levels = array();
        foreach ($items as $item)
        {
            $item['children'] = array();
            $level = $item['level'];
            if ( ! isset($levels[$level]) )
            {
                $levels[$level] = array();
            }
            $levels[$level][] = $item;
        }

        for ($i = count($levels); $i > 1; $i--)
        {
            foreach ($levels[$i] as $elm)
            {
                foreach ($levels[$i-1] as &$parent_elm)
                {
                    if ($elm['parent_id'] == $parent_elm['id'])
                    {
                        $parent_elm['children'][] = $elm;
                        break;
                    }
                }
            }
        }

        $tree_array = $levels[1];
        return $tree_array;
    }
}

if ( ! function_exists('tree_dropdown_options')) {

    /**
     * Преобразование массива элементов в древовидную структуру для тега <select>
     * @param array $items
     *      Каждый элемент данного массива должен содержать значения со следующими ключами:
     *      id - value для тега <option>
     *      name - текст внутри тега <option>
     *      parent_id - id родителя
     *      level - уровень
     *      order - порядковый номер среди одноуровневых элементов
     * @param int $current_id
     * @param string $indent
     * @return array
     */
    function tree_dropdown_options($items, $current_id = 0, $indent = '...')
    {
        $tree = array_tree($items);
        $options = array(0 => '');

        function dropdown_option(& $options, $items, $current_id, $indent)
        {
            foreach ($items as $item)
            {
                // Не отображать текущий элемент (нельзя ведь сделать род. пунктом самого себя)
                if ($item['id'] == $current_id)
                    continue;

                $indentation = '';
                for ($i=0; $i < $item['level']-1; $i++)
                    $indentation .= $indent;
                $options[$item['id']] = $indentation .' '. $item['name'];

                if (count($item['children']) > 0)
                {
                    dropdown_option($options, $item['children'], $current_id, $indent);
                }
            }
        }

        dropdown_option($options, $tree, $current_id, $indent);

        return $options;
    }
}

if ( ! function_exists('tree_ordered_list')) {

    function tree_ordered_list($items)
    {
        $tree = array_tree($items);
        $output = array();

        function parse_level(&$output, $level_arr)
        {
            foreach ($level_arr as $item)
            {
                $output[] = $item;
                if (count($item['children']) > 0)
                    parse_level($output, $item['children']);
            }
        }

        parse_level($output, $tree);

        return $output;
    }
}

if ( ! function_exists('tree_menu')) {

    function tree_menu($items, $attrs = array())
    {
        $treeArr = array_tree($items);

        function build_menu($rows, $parent_id=0, $attrs = array())
        {
            if ($parent_id == 0)
            {
                $html = '<ul';
                foreach ($attrs as $key => $value)
                    $html .= ' '.$key.'="'.$value.'"';
                $html .= '>';
            }
            else
            {
                $html = '<ul>';
            }

            foreach ($rows as $row)
            {
                $html .= "<li>{$row['name']}";
                if (count($row['children']) > 0)
                {
                    $html .= build_menu($row['children'], $row['id']);
                }
                $html .= '</li>';
            }
            $html .= '</ul>';
            return $html;
        }

        return build_menu($treeArr, 0, $attrs);
    }
}

if ( ! function_exists('tree_edit_menu')) {

    function tree_edit_menu($items, $attrs = array())
    {
        $treeArr = array_tree($items);

        function build_menu($rows, $parent_id=0, $attrs = array())
        {
            if ($parent_id == 0)
            {
                $html = '<ul';
                foreach ($attrs as $key => $value)
                    $html .= ' '.$key.'="'.$value.'"';
            }
            else
            {
                $html = '<ul';
            }
            $html .= ' class="sortable-list"';
            $html .= '/>';

            foreach ($rows as $row)
            {
                $html .= '<li><div>';
                $html .= '<a class="drag-handler-wrap"><div class="drag-handler"></div></a>';
                $html .= $row['name'];
                $html .= '</div>';
                if (count($row['children']) > 0)
                {
                    $html .= build_menu($row['children'], $row['id']);
                }
                $html .= '</li>';
            }
            $html .= '</ul>';
            return $html;
        }

        return build_menu($treeArr, 0, $attrs);
    }
}