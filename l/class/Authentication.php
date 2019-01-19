<?php

class Authentication{
    private $onn = null;
    static private $instance = NULL;
    static private $identity = NULL;

    static function getInstance(){
        if(self::$instance == NULL){
            self::$instance == new Authentication();
        }
        return self::$instance;
    }

    private function __construct(){
    if(isset($_SESSION['identity'])){
        self::$identity = $_SESSION['identity'];
    }
    $this->conn = Connection::getPdoInstance();

    }

    public function login($email, $password){
        //todo
    }

    public function hasIdentity(){
        //todo
    }
    public function getIdentity(){
        //todo
    }
    public function logout(){
        //todo
    }


}