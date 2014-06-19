<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace My\Application;

use My\Service\UserService;
use My\Service\ValidatorService;

session_start();

require_once "Dao\BaseDao.php";
require_once "Dao\UserDao.php";
require_once "Service\ValidatorService.php";
require_once "Service\UserService.php";


class UserApplication
{
    public function __construct(UserService $userService, ValidatorService $validator)
    {
        $this->userService  = $userService;
        $this->validator    = $validator;
        
        if (isset($_POST['login']))
        {
            $this->login();
        }
        elseif (isset($_POST['register']))
        {
            $this->register();
        }
        elseif (isset($_POST['update']))
        {
            $this->update();
        }
        elseif (isset($_GET['logout']))
        {
            $this->logout();
        }
    }
    
    public function login()
    {
        $success = $this->userService->login($_POST);
        
        if ($success)
        {
            $_SESSION['statusMsg'] = "Successful login!";
            header("Location: index.php");
        }
        else
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: login.php");
        }
    }
    
    public function register ()
    {
        $success = $this->userService->register($_POST);
        
        if ($success)
        {
            $_SESSION['statusMsg'] = "Registration was successful!";
            header("Location: index.php");
        }
        else
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: register.php");
        }
    }
    
    public function update ()
    {
        $success = $this->userService->update($_POST);
        
        if ($success)
        {
            $_SESSION['statusMsg'] = "Successfully Updated!";
            header("Location: profile.php");
        }
        else
        {
            $_SESSION['value_array'] = $_POST;
            $_SESSION['error_array'] = $this->validator->getErrorArray();
            header("Location: profileedit.php");
        }
    }
    
    public function logout ()
    {
        $success = $this->userService->logout();
        header("Location: index.php");
    }
}

$userApp = new \My\Application\UserApplication($userService, $validator);

?>