<?php

Class DBConnection
{
    private $_config = array();
    public  $db      = null;
    public  $error   = null;

    public function __construct($configfile = "../config/config.ini")
    {
        try {
            $this->_config = parse_ini_file($configfile, true);
            try {
                $this->db = new PDO('mysql:host=' . $this->_config['DB']['host'] 
                        . ';dbname=' . $this->_config['DB']['dbname'], 
                        $this->_config['DB']['user'], 
                        $this->_config['DB']['password']);
            } catch (PDOException $e) {
                $this->error = "DB Connection Failed";
                print "DB Connection Failed"; 
            } 
        } catch (Exception $e) {
            $this->error = "Unable to find config file";
            print "Unable to find config file";
        }
    }

    public function __destruct()
    {
        $this->db = null;
    }
}
