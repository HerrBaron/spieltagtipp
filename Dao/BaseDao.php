<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace My\Dao;

abstract class BaseDao
{
    private $db     = null;
    
    const DB_SERVER = "localhost";
    const DB_USER   = "root";
    const DB_PASS   = "";
    const DB_NAME   = "spieltagtipp";
    
    protected final function getDB()
    {
        $dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::DB_SERVER;
        
        #var_dump($dsn);
        
        try 
        {
            $this->db = new \PDO($dsn, self::DB_USER, self::DB_PASS);
        } catch (PDOException $ex) 
        {
            throw new \Exception('Connection failed: ' . $ex->getMessage());
        }
        
        return $this->db;
    }
    
    abstract protected function get($uniqueKey);
    abstract protected function insert(array $values);
    abstract protected function update($id, array $values);
    abstract protected function delete($uniqueKey);
}

?>