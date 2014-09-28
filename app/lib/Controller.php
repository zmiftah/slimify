<?php

namespace App\Lib;

use App\Lib\Application;

class Controller 
{
    protected $per_page = 2; //for pager

    public function defaultVars()
    {
        $vars['base_url'] = BASE_URL;
        $vars['assets_url'] = ASSETS_URL;
        $vars['app_title'] = 'Aplikasi Penjadwalan';
        $vars['app_description'] = 'Aplikasi Penjadwalan';

        return $vars;
    }

    public function getApp()
    {
        return Application::getInstance();
    }

    public function redirectUrl($url)
    {
        $this->getApp()->redirectUrl($url);
    }

    public function noAkses()
    {
        echo $this->getApp()->render('no_akses.twig', $this->defaultVars());
        exit();
    }

    public function renderTpl($template, $vars=[])
    {
        $App = $this->getApp();

        // ACL
        $vars['has_login'] = $App->auth->hasLogin();
        $vars['acl']       = $App->auth->getPermissions();
        $vars['username']  = $App->auth->getUsername();
        $vars['email']     = $App->auth->getUserEmail();
        $vars['role']      = $App->auth->getRole();

        // Presentation Layer
        $vars = array_merge($vars, $this->defaultVars());

        $template .= (strpos($template, '.twig')>0) ? "" : ".twig";
        return $this->getApp()->render($template, $vars);
    }

    public function setReturnUrl($url)
    {
        $this->getApp()->session->flashSet('return_url', $url);
    }

    public function getReturnUrl()
    {
        $url = $this->getApp()->session->flashGet('return_url');
        return $url;
    }
}