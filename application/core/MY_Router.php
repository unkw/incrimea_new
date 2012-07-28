<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {

    public function _validate_request($segments) {
        if (count($segments) == 0) return $segments;

        /* locate module controller */
        $segments = $this->_get_real_segments($segments);
        if ($located = $this->locate($segments)) return $located;

        /* use a default 404_override controller */
        if (isset($this->routes['404_override']) AND $this->routes['404_override']) {
            $segments = explode('/', $this->routes['404_override']);
            if ($located = $this->locate($segments)) return $located;
        }

        /* no controller found */
        show_404();
    }

    private function _get_real_segments($segments)
    {
        require_once( BASEPATH .'database/DB'. EXT );
        $db =& DB();

        $url = implode('/', $segments);
        $real_path = $db->get_where('url_aliases', array('alias' => $url))->row_array();

        if ($real_path && !empty($real_path)) {
            $segments = explode('/', $real_path['path']);
        }

        return $segments;
    }

}