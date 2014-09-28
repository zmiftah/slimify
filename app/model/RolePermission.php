<?php

namespace App\Model;

class RolePermission extends \Model
{
    public static $_table = 't_role_permission';

    public function role() {
        $role = Role::find_one($this->role_id);
        return $role;
    }

    public function permission() {
        $perm = Permission::find_one($this->permission_id);
        return $perm;
    }
}