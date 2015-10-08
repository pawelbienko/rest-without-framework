<?php

namespace Api\Model;

use PDO;

/**
 * Description of Model.
 *
 * @author symfony
 */
abstract class Model
{
    /**
     * object of the class PDO.
     * 
     * @var object
     */
    protected $pdo;

    /**
     * It sets connect with the database.
     */
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.DATABASE_HOST.';dbname='
                .DATABASE_NAME, DATABASE_USER, DATABASE_PASSOWD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
