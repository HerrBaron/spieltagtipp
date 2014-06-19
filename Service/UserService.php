<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace My\Service;
use My\Dao\UserDao;
use My\Service\ValidatorService;

class UserService
{
    public  $useremail;
    private $userid;
    public  $username;
    public  $first_name;
    public  $last_name;
    private $userhash;
    private $userlevel;
    public  $logged_in;
    
    const ADMIN_EMAIL   = "admin@spieltagtipps.de";
    const GUEST_NAME    = "Guest";
    const ADMIN_LEVEL   = 9;
    const USER_LEVEL    = 1;
    const GUEST_LEVEL   = 0;
    
    const COOKIE_EXPIRE = 8640000; #100 days
    const COOKIE_PATH   = "/";
    
    public function __construct(UserDao $userDao, ValidatorService $validator)
    {
        $this->userDao      = $userDao;
        $this->validator    = $validator;
        $this->logged_in    = $this->isLogin();
        
        if (!$this->logged_in)
        {
            $this->useremail = $_SESSION['useremail'] = self::GUEST_NAME;
            $this->userlevel = self::GUEST_LEVEL;
        }
    }
    
    private function isLogin()
    {
        if (isset($_SESSION['useremail']) && isset($_SESSION['userhash']) && $_SESSION['useremail'] != self::GUEST_NAME)
        {
            if ($this->userDao->checkHashConfirmation($_SESSION['useremail'], $_SESSION['userhash']) === FALSE)
            {
                unset($_SESSION['useremail']);
                unset($_SESSION['userhash']);
                unset($_SESSION['userid']);
                return FALSE;
            }
            $userinfo = $this->userDao->get($_SESSION['useremail']);
            if (!$userinfo)
            {
                return FALSE;
            }
            
            $this->useremail    = $userinfo['useremail'];
            $this->userid       = $userinfo['id'];
            $this->userhash     = $userinfo['userhash'];
            $this->userlevel    = $userinfo['userlevel'];
            $this->username     = $userinfo['username'];
            $this->first_name   = $userinfo['first_name'];
            $this->last_name    = $userinfo['last_name'];
            
            return TRUE;
        }
        
        if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid']))
        {
            $this->useremail = $_SESSION['useremail'] = $_COOKIE['cookname'];
            $this->userhash = $_SESSION['userhash'] = $_COOKIE['cookid'];
            return TRUE;
        }
        return FALSE;
    }
    
    public function login($values)
    {
        $useremail      = $values['useremail'];
        $password       = $values['password'];
        $rememberme    = isset($values['rememberme']);
        
        $this->validator->validate("useremail", $useremail);
        $this->validator->validate("password", $password);
        
        if ($this->validator->num_errors > 0)
        {
            return FALSE;
        }

        if (!$this->validator->validateCredential($useremail, $password))
        {
            return FALSE;
        }
        
        $userinfo = $this->userDao->get($useremail);
        
        if (!$userinfo)
        {
            return FALSE;
        }
        
        $this->useremail    = $_SESSION['useremail'] = $userinfo['useremail'];
        $this->userid       = $_SESSION['userid']   = $userinfo['id'];
        $this->userhash     = $_SESSION['userhash'] = md5(microtime());
        $this->userlevel    = $userinfo['userlevel'];
        $this->usename      = $userinfo['username'];
        $this->last_name    = $userinfo['last_name'];
        $this->first_name   = $userinfo['first_name'];
        
        $this->userDao->update($this->userid, array("userhash" => $this->userhash));
        
        if ($rememberme == 'true')
        {
            setcookie("cookname", $this->useremail, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH);
            setcookie("cookid", $this->userhash, time() + self::COOKIE_EXPIRE, self::COOKIE_PATH);
        }
        return TRUE;
    }
    
    public function register ($values)
    {
        $username   = $values['username'];
        $useremail  = $values['useremail'];
        $password   = $values['password'];
        $first_name = $values['first_name'];
        $last_name  = $values['last_name'];
        
        $this->validator->validate("username", $username);
        $this->validator->validate("first_name", $first_name);
        $this->validator->validate("last_name", $last_name);
        $this->validator->validate("useremail", $useremail);
        $this->validator->validate("password", $password);
        
        if($this->validator->num_errors > 0)
        {
            return FALSE;
        }
        
        if ($this->validator->emailExists($useremail))
        {
            return FALSE;
        }
        
        $ulevel = (strcasecmp($useremail, self::ADMIN_EMAIL) == 0) ? self::ADMIN_LEVEL : self::USER_LEVEL;
        
        return $this->userDao->insert(array(
            'useremail'     => $useremail,
            'password'      => md5($password),
            'userlevel'     => $ulevel,
            'username'      => $username,
            'first_name'    => $first_name,
            'last_name'     => $last_name
        ));
    }
    
    public function getUser($useremail)
    {
        $this->valdator->validate("useremail", $useremail);
        
        if ($this->validator->num_errors > 0)
        {
            return FALSE;
        }
        
        if (!$this->validator->emailExists($useremail))
        {
            return FALSE;
        }
        
        $userinfo = $this->userDao->get($usermail);
        
        if ($userinfo)
        {
            return $userinfo;
        }
        return FALSE;
    }
    
    public function update ($values)
    {
        $username       = $values['username'];
        $first_name     = $values['first_name'];
        $last_name      = $values['last_name'];
        $password       = $values['password'];
        $newPassword    = $values['newPassword'];
        
        $updates = array();
        
        if ($username)
        {
            $this->validator->validate("username", $username);
            $updates['username'] = $username;
        }
        
        if ($first_name)
        {
            $this->validator->validate("first_name", $first_name);
            $updates['first_name'] = $first_name;
        }
        
        if ($last_name)
        {
            $this->validator->validate("last_name", $last_name);
            $updates['last_name'] = $last_name;
        }
        
        if ($password && $newPassword)
        {
            if ($this->validator->checkPassword($this->useremail, $password) === FALSE)
            {
                return FALSE;
            }
            $updates['password'] = md5($password);
        }
        
        $this->userDao->update($this->userid, $updates);
        
        return TRUE;
    }
    
    public function isAdmin() 
    {
        return ($this->userlevel == self::ADMIN_LEVEL ||
                $this->useremail == self::ADMIN_EMAIL);
    }
    
    public function logout()
    {
        if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid']))
        {
            setcookie("cookname", "", time() - self::COOKIE_EXPIRE, self::COOKIE_PATH);
            setcookie("cookid", "", time() - self::COOKIE_EXPIRE, self::COOKIE_PATH);
        }
        
        unset($_SESSION['useremail']);
        unset($_SESSION['userhash']);
        
        $this->logged_in = FALSE;
        
        $this->useremail = self::GUEST_NAME;
        $this->userlevel = self::GUEST_LEVEL;
    }
}
$userService = new \My\Service\UserService($userDao, $validator);
?>
