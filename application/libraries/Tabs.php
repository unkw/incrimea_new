<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 27.07.12
 * Time: 23:41
 * To change this template use File | Settings | File Templates.
 */
class Tabs {

    private $CI,
            $collection = array();

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * @param string|array $value
     * @param string $href
     */
    public function add($value, $href = '')
    {
        if (is_array($value))
        {
            foreach ($value as $tab)
            {
                $this->collection[] = array(
                    'title' => $tab[0],
                    'href' => $tab[1]
                );
            }
        }
        else
        {
            $this->collection[] = array(
                'title' => $value,
                'href'  => $href
            );
        }

    }

    public function display()
    {
        $data = array(
            'tabs' => $this->collection
        );
        return $this->CI->load->view('tpl/admin/tabs', $data, TRUE);
    }
}