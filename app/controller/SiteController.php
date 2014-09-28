<?php

namespace App\Controller;

use App\Lib\Controller;
use App\Lib\Session;
use App\Lib\Auth;
use App\Model\User;

class SiteController extends Controller
{
    public function checkLogin()
    {
        if ($_SESSION['has.login']) {
            $this->redirectUrl('timeline');
        } else {
            $this->formLogin();
        }
    }

    public function formLogin()
    {
        // Jika sudah login maka masuk timeline
        if (isset($_POST['username'])) {
            $message = $this->login();
        }
        $this->renderTpl('site_login', compact('message'));
    }

    public function login()
    {
        $username = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
        $password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING );

        // Verify
        $user = $this->getApp()->auth->verify($username, $password);

        if ($user instanceof User) {
            // Get Role
            $role = $user->role();
            // Add Session 
            $this->getApp()->auth->login($user, $role);
            // Redirect
            $this->getApp()->redirectUrl('timeline');
        } else {
            // Pesan Login Gagal
            return 'Login Gagal!';
        }
    }

    public function logout()
    {
        // Proses Logout
        $this->getApp()->session->logout();
        $this->redirectUrl('login');
    }
}