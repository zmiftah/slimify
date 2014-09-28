<?php 

namespace App\Lib;

use \Slim\Slim;

class Application extends Slim
{
    public function redirectUrl($url)
    {
        $url = $this->request->getRootUri().'/'.$url;
        $this->redirect($url);
    }
}