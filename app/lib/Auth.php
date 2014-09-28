<?php

namespace App\Lib;

use App\Model\User;

class Auth
{
    public $useExpire;

    public function __construct($useExpire=false)
    {
        $this->useExpire = $useExpire;
    }

    public function verify( $username, $password )
    {
        $user = User::where('name', $username)->find_one();
        $valid = $user->password == md5( $password );

        return $valid ? $user : false;
    }

    public function verifyACL($key)
    {
        $acl = $this->getPermissions();
        $valid = $acl[$key]['value'] == 1;
        return $valid;
    }

    public function login($user, $role)
    {
        $_SESSION['role.id']          = $role->id;
        $_SESSION['role.name']        = $role->name;
        $_SESSION['role.permissions'] = $role->permissions();
        
        $_SESSION['user.id']          = $user->id;
        $_SESSION['user.name']        = $user->name;
        $_SESSION['user.email']       = $user->email;
        
        $_SESSION['has.login']        = true;
        $_SESSION['login.time']       = date('Y-m-d H:i:s');
        $_SESSION['login.expire']     = '+8 hour'; // Default: 8 jam.
    }

    public function isValid()
    {
        $auth = array( 
            'valid' => false, 
            'expire' => false 
        );

        // Auth Check Valid User
        $auth['valid'] = ( $this->hasLogin() == true && $this->getUsername() !== null );
        
        // Auth Check Expire Time
        if ($this->useExpire) {
            $now = new DateTime;
            $login = new DateTime($_SESSION['login.time']);
            $login->modify($_SESSION['login.expire']);
            
            $auth['expire'] = ( $login < $now );
        }

        return $auth;
    }

    public function hasLogin()
    {
        return $_SESSION['has.login'];
    }

    public function getUserId()
    {
        return $_SESSION['user.id'];
    }

    public function getUsername()
    {
        return $_SESSION['user.name'];
    }

    public function getUserEmail()
    {
        return $_SESSION['user.email'];
    }

    public function getRole()
    {
        return $_SESSION['role.name'];
    }

    public function getPermissions()
    {
        return $_SESSION['role.permissions'];
    }
}