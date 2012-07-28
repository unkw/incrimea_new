<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kemal
 * Date: 09.06.12
 * Time: 11:00
 * To change this template use File | Settings | File Templates.
 */
class Auth {

    private $CI;
    /**
     * @var object|null Данные пользователя
     */
    private $userdata = null;
    private $identityColumn = 'email';

    public function __construct()
    {
        $this->CI =& get_instance();

        // Идентификация пользователя
        $this->_userIdentity();
    }

    /**
     * Авторизация
     * @param string $identity
     * @param string $pass
     * @return bool
     */
    public function login($identity, $pass)
    {
        $user = $this->CI->db
            ->select('id')
            ->from('users')
            ->where(array(
                $this->identityColumn => $identity,
                'password' => sha1($pass)
            ))
            ->get()->row();

        if ($user)
        {
            $this->CI->session->set_userdata('uid', $user->id);
            $this->updateActivity();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Разлогинивание
     */
    public function logout()
    {
        $this->userdata = null;
        $this->CI->session->sess_destroy();
    }

    /**
     * Залогинен ли пользователь
     * @return bool
     */
    public function isLogged()
    {
        return $this->CI->session->userdata('uid') ? TRUE : FALSE;
    }

    /**
     * Обновление активности (последний вход)
     */
    public function updateActivity()
    {
        if ($this->isLogged())
        {
            $this->CI->db
                ->where('id', $this->CI->session->userdata('uid'))
                ->update('users', array('last_login' => time()));
        }
    }

    /**
     * Получение данных пользователя
     * @return array|null
     */
    public function user()
    {
        if ($this->isLogged())
        {
            if (is_null($this->userdata))
            {
                $this->userdata = $this->CI->db
                    ->select('u.*, r.name as role')
                    ->from('users as u')
                    ->join('roles as r', 'u.role_id = r.id')
                    ->where(array('u.id' => $this->CI->session->userdata('uid')))
                    ->get()->row();
            }
        }
        return $this->userdata;
    }

    /**
     * Идентификация пользователя при запуске приложения
     */
    private function _userIdentity()
    {
        if ($this->CI->session->userdata('uid'))
        {
            $user = $this->CI->db
                ->get_where('users', array('id' => $this->CI->session->userdata('uid')));

            if (!$user)
            {
                $this->CI->session->sess_destroy();
            }
        }
    }

}
