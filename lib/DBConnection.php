<?php

Class DBConnection
{
    private $config = array();
    public  $db     = null;
    public  $error  = null;

    public function __construct($configfile = "../config/config.ini")
    {
        try {
            $this->config = parse_ini_file($configfile, TRUE);
            try {
                $this->db = new PDO('mysql:host=' . $this->config['DB']['host'] 
                        . ';dbname=' . $this->config['DB']['dbname'], 
                        $this->config['DB']['user'], $this->config['DB']['password']);
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
