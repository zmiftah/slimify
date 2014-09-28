<?php

namespace App\Model;

class Role extends \Model
{
    public static $_table = 't_role';

    public function users() 
    {
        $users = User::where('role_id', $this->id)->find_many();
        return $users;
    }

    public function permissions() 
    {
        $role_perms = RolePermission::where('role_id', $this->id)->find_many();
        $data = array();

        if( $role_perms ) {
            foreach ( $role_perms as $role_perm ) {
                if ( $role_perm->value == 1 ) {
                    $perm = $role_perm->permission();
                    $data["$perm->key"] = $perm->as_array();
                    $data["$perm->key"]['value'] = $role_perm->value;
                }
            }
        }

        return $data;
    }
}