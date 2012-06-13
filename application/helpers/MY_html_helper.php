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