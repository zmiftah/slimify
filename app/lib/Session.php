<?php 

namespace App\Lib;

/*
 * Session Handling for Auth
 * 
 * @package 	: app\lib
 * @author  	: Zein Miftah
 * @copyright 	: 2014
 * 
 * @last-update : 2014-09-17
 */

class Session
{
	private $_useExpire;

	public function __construct($useExpire=false)
	{
		$this->_useExpire = $useExpire;
	}

	public function start() 
	{
		// See: http://docs.slimframework.com/#Native-Session-Store
		session_cache_limiter(false);
		session_start();
	}

	public function logout() 
	{
		foreach ($_SESSION as $session => $val) {
			unset($_SESSION[$session]);
		}
		
		// session_destroy();
	}

	public function flashSet($name, $value) 
	{
		$_SESSION["flash"]["$name"] = $value;
	}

	public function flashGet($name)
	{
		if (isset($_SESSION["flash"]["$name"])) {
			$flash = $_SESSION["flash"]["$name"];
			unset( $_SESSION["flash"]["$name"] );

			return $flash;
		} else {
			return null;
		}
	}
}
	