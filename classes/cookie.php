<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Core;

/**
 * Cookie class
 *
 * @package    Fuel
 * @category   Helpers
 * @author     Kohana Team
 * @modified   Phil Sturgeon - Fuel Development Team
 * @copyright  (c) 2008-2010 Kohana Team
 * @license    http://kohanaframework.org/license
 * @link       http://fuelphp.com/docs/classes/cookie.html
 */
class Cookie {

	/**
	 * Gets the value of a signed cookie. Cookies without signatures will not
	 * be returned. If the cookie signature is present, but invalid, the cookie
	 * will be deleted.
	 *
	 *     // Get the "theme" cookie, or use "blue" if the cookie does not exist
	 *     $theme = Cookie::get('theme', 'blue');
	 *
	 * @param   string  cookie name
	 * @param   mixed   default value to return
	 * @return  string
	 */
	public static function get($name, $default = null)
	{
		return \Input::cookie($name, $default);
	}

	/**
	 * Sets a signed cookie. Note that all cookie values must be strings and no
	 * automatic serialization will be performed!
	 *
	 *     // Set the "theme" cookie
	 *     Cookie::set('theme', 'red');
	 *
	 * @param   string   name of cookie
	 * @param   string   value of cookie
	 * @param   integer  lifetime in seconds
	 * @param   string   path of the cookie
	 * @param   string   domain of the cookie
	 * @param   boolean  only transmit over secure HTTPS connection from client
	 * @param   boolean  make cookie accessible only through HTTP protocol, not through scripting languages
	 * @return  boolean
	 */
	public static function set($name, $value, $expiration = null, $path = null, $domain = null, $secure = null, $http_only = null)
	{
		if ($expiration === null)
		{
			$expiration = \Config::get('cookie.expiration', 86400);
		}

		// If expiration > 0, need to add to current time. If expiration == 0, cookie will expire at end of session or when browser closes
		if ($expiration > 0)
		{
			$expiration += time();
		}

		if ($path === null)
		{
			$path = \Config::get('cookie.path', '/');
		}

		if ($domain === null)
		{
			$domain = \Config::get('cookie.domain', '');
		}

		if ($secure === null)
		{
			$secure = \Config::get('cookie.secure', false);
		}

		if ($http_only === null)
		{
			$http_only = \Config::get('cookie.http_only', false);
		}

		return setcookie($name, $value, $expiration, $path, $domain, $secure, $http_only);
	}

	/**
	 * Deletes a cookie by making the value null and expiring it.
	 *
	 *     Cookie::delete('theme');
	 *
	 * @param   string   cookie name
	 * @return  boolean
	 * @uses    static::set
	 */
	public static function delete($name)
	{
		// Remove the cookie
		unset($_COOKIE[$name]);

		// Nullify the cookie and make it expire
		return static::set($name, null, -86400);
	}
}

/* End of file cookie.php */
