<?php

namespace Api\Controller;

/*
 * Class supports authentication to applications.
 */
class AuthenticationController
{
    /*
     * Function checks whether the specified authentication details are correct.
     *  
     * @return bool
     */
    public static function login()
    {
        if (($_SERVER['PHP_AUTH_USER'] != AUTH_USER)
            && ($_SERVER['PHP_AUTH_PW'] != AUTH_PW)) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * Function checks whether the user is already logged.
     * 
     * @return bool
     */
    public static function isLogged()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            return false;
        } else {
            return true;
        }
    }

    /*
     * Function sends a headers after a failed login.
     * 
     * @return void
     */
    public static function unauthorized()
    {
        header('WWW-Authenticate: Basic realm="Private Area"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    }
}
