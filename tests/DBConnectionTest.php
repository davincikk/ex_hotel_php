<?php
require_once "DBConnection.php";

class DBConnectionTest extends PHPUnit_Framework_TestCase
{

    public function testDBConnection()
    {
        $this->assertContainsOnlyInstancesOf('DBConnection',array(new DBConnection()));
    }
    
    public function testConfigFile()
    {
        $tempObj = new DBConnection("configbkp.ini");
        $this->assertEquals($tempObj->error, "Unable to find config file");
    }
    public function testConfigDBFile()
    {
        $tempObj = new DBConnection("config_test.ini");
        $this->assertEquals($tempObj->error, "DB Connection Failed");
    }

}
?>
