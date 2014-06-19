<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace My\Service;

use My\Dao\UserDao;

class ValidatorService
{
    private $values = array();
    private $errors = array();
    
    public $statusMsg = null;
    public $num_errors;
    
    const NAME_LENGTH_MIN = 5;
    const NAME_LENGTH_MAX = 100;
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 32;
    
    public function __construct()
    {
        if (isset ($_SESSION['value_array']) && isset($_SESSION['error_array']))
        {
            $this->values = $_SESSION['value_array'];
            $this->errors = $_SESSION['error_array'];
            $this->num_errors = count($this->errors);
            
            unset($_SESSION['value_array']);
            unset($_SESSION['error_array']);
        }
        else
        {
            $this->num_errors = 0;
        }
        
        if (isset($_SESSION['statusMsg']))
        {
            $this->statusMsg = $_SESSION['statusMsg'];
            unset($_SESSION['statusMsg']);
        }
    }
    
    public function setUserDao(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }
    
    public function setValue($field, $value)
    {
        $this->values[$field] = $value;
    }
    
    public function getValue($field)
    {
        if (array_key_exists($field, $this->values))
        {
            return htmlspecialchars(stripcslashes($this->values[$field]));
        }
        else 
        {
            return "";
        }
    }
    
    private function setError($field, $errmsg)
    {
        $this->errors[$field] = $errmsg;
        $this->num_errors = count($this->errors);
    }
    
    public function getError($field)
    {
        if (array_key_exists($field, $this->errors))
        {
            return $this->errors[$field];
        }
        else
        {
            return "";
        }
    }
    
    public function getErrorArray()
    {
        return $this->errors;
    }
    
    public function validate($field, $value)
    {
        $valid = FALSE;
        
        if ($valid == $this->isEmpty($field, $value))
        {
            $valid = TRUE;
            
            if($field == "username")
            {
                $valid = $this->checkSize($field, $value,self::NAME_LENGTH_MIN, self::NAME_LENGTH_MAX);
            }
            
            if($field == "last_name")
            {
                $valid = $this->checkSize($field, $value,self::NAME_LENGTH_MIN, self::NAME_LENGTH_MAX);
            }
            
            if($field == "first_name")
            {
                $valid = $this->checkSize($field, $value,self::NAME_LENGTH_MIN, self::NAME_LENGTH_MAX);
            }
            
            if ($field == "password" || $field == "newpassword")
            {
                $valid = $this->checkSize($field, $value, self::PASS_LENGTH_MIN, self::PASS_LENGTH_MAX);
            }
            
            if($valid)
            {
                $valid = $this->checkFormat($field, $value);
            }
        }
        
        return $valid;
    }
    
    private function isEmpty($field, $value)
    {
        $value = trim($value);
        
        if (empty($value))
        {
            $this->setError($field, "Field value not entered!");
            return TRUE;
        }
        return FALSE;
    }
    
    private function checkFormat($field, $value)
    {        
        switch($field)
        {
            case 'useremail':
                $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                       . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                       . "\.([a-z]{2,}){1}$/i";
                $msg = "Email address invalid!";
                break;
            case 'password':
            case 'newpassword':
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Password not alphanumeric!";
                break;
            case 'username':
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Username must be alphanumeric!";
                break;
            case 'first_name':
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Firstname must be alphanumeric!";
                break;
            case 'last_name':
                $regex = "/^([0-9a-z])+$/i";
                $msg = "Lastname must be alphanumeric!";
                break;
            default:;
        }
        if (!preg_match($regex, ($value = trim($value))))
        {
            $this->setError($field, $msg);
            return FALSE;
        }
        return TRUE;
    }
    
    private function checkSize ($field, $value, $minLength, $maxLength)
    {
        $value = trim($value);
        
        if (strlen($value) < $minLength || strlen($value) > $maxLength)
        {
            $this->setError($field, "Value length should be within " . $minLength . " and " . $maxLength . " characters");
            return FALSE;
        }
        return TRUE;
    }
    
    public function validateCredential ($useremail, $password)
    {
        $result = $this->userDao->checkPassConfirmation($useremail, md5($password));

        if ($result === false) {
            $this->setError("password", "Email address or password is incorrect");
            return FALSE;
        }
        return TRUE;
    }
    
    public function emailExists ($useremail)
    {
        if ($this->userDao->userEmailTaken($useremail))
        {
            $this->setError('useremail', "Email already in use");
            return TRUE;
        }
        return FALSE;
    }

    public function checkPassword($useremail, $password) {
        
        $result = $this->userDao->checkPassConfirmation($useremail, md5($password));

        if ($result === false) {
            $this->setError("password", "Current password incorrect");
            return FALSE;                    
        }
        return TRUE;
    }
}   

$validator = new \My\Service\ValidatorService;
$validator->setUserDao($userDao);

?>