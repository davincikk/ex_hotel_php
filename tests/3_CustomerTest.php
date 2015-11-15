<?php
require_once "Customer.php";

class CustomerTest extends PHPUnit_Framework_TestCase
{

    public function dataCustomer()
    {
        return array(
            array(array('name' => 'Customer 1',
                        'email' => 'test@test.com',
                        'address1' => ' Addrte S@#@$@ F SDF S=-- ..,i\'',
                        'address2' => '',
                        'phone' => '1214131313'), array(TRUE,'')),
            array(array('name' => 'Customer 22',
                        'email' => 'test@test2.com',
                        'address1' => ' Addrtesa sd S@#@$@ F SDF S=-- ..,i\'',
                        'address2' => 'aa DAS DAS?><"P',
                        'phone' => '121431313'), array(TRUE,'')),
            array(array('name' => 'Customer 2',
                        'email' => 'Cust@test.com',
                        'address1' => ' Addrtesa sd S@#@$@ F SDF S=-- ..,i\'',
                        'address2' => 'aa DAS DAS?><"P',
                        'phone' => '1214131313'), array(FALSE,'Unable to create record')),
            array(array('name' => 'Customer 3',
                        'email' => 'Cust@test.com',
                        'phone' => '1214131313'), array(FALSE,'Unable to create record, not enough records'))
        );
    } 

    public function updateCustomer()
    {
        return array(
            array('cust_id' => 1, array('name' => 'Customer 12'), 
                        array(TRUE, NULL)),
            array('cust_id' => 1, array(), 
                        array(FALSE, 'No Data to update')),
            array('cust_id' => '', array(), 
                        array(FALSE, 'No Data to update')),
            array('cust_id' => 1, array('nae' => 'Customer 11'), 
                        array(FALSE, 'Update Failed'))
        );
    }

    public function getCustomerId()
    {
        return array(
                array(1, ""),
                array(4, "No matching record")
        );
    }

    /**
     * @dataProvider dataCustomer
     */
    public function testCreateCustomer($data, $expected)
    {
        $tempObj = new Customer();
        $this->assertContainsOnlyInstancesOf('Customer', array($tempObj));
        $createStatus = $tempObj->createCustomer($data);
        $this->assertEquals($createStatus, $expected[0]);
        $this->assertEquals($tempObj->error, $expected[1]);
    
    } 
    /**
     * @dataProvider updateCustomer
     */
    public function testUpdateCustomer($id, $data, $expected)
    {
        $tempObj = new Customer();
        $createStatus = $tempObj->updateCustomer($data, $id);
        $this->assertEquals($createStatus, $expected[0]);
        $this->assertEquals($tempObj->error, $expected[1]);
    }
   
    public function testgetAllCustomer()
    {
        $tempObj = new Customer();
        $selectStatus = $tempObj->getAllCustomer();
        $this->assertEquals(count($selectStatus), 2);
    }

    /**
     * @dataProvider getCustomerId
     */
    public function testgetCustomerById($id, $expected)
    {
        $tempObj = new Customer();
        $selectStatus = $tempObj->getCustomerById($id);
        $this->assertEquals($tempObj->error, $expected);
    }

}
?>
