<?php

namespace App\Model;

class User extends \Model
{
    public static $_table = 't_user';

    public function role() 
    {
        $role = Role::find_one($this->role_id);
        return $role;
    }
}