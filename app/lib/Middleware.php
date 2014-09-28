<?php

namespace App\Lib;

class Middleware
{
    public function checkLogin()
    {
        $App = Application::getInstance();

        $auth = $App->auth->isValid(); // Check Auth
        $url = $_SERVER['REQUEST_URI'];

        if ( !$auth['valid'] ) {
            $App->session->flashSet('auth_url', $url);
            $App->session->flashSet('auth_message', 'You are Not Authenticated!');
            $App->redirectUrl('login');
        }

        if ( $auth['expire'] ) {
            $App->session->flashSet('auth_url', $url);
            $App->session->flashSet('auth_message', 'Login Expired!');
            $App->redirectUrl('login');
        }
    }
}