<?php
require_once "Rooms.php";

class RoomsTest extends PHPUnit_Framework_TestCase
{

    public function dataRoom()
    {
        return array(
            array(array('room_name' => 'Suite 1',
                        'status' => 'Ready',
                        'room_type_id' => 1), TRUE),
            array(array('room_name' => 'Suite 2',
                        'status' => 'Occupied',
                        'room_type_id' => 3), TRUE),
            array(array('room_name' => 'Suite 3',
                        'status' => 'Cleaning',
                        'room_type_id' => 6), FALSE)
        );
    } 

    public function updateRoom()
    {
        return array(
            array('room_id' => 1, array('room_name' => 'Suite 4'), 
                        array(TRUE, NULL)),
            array('room_id' => 1, array(), 
                        array(FALSE, 'Not Enough data to update record')),
            array('room_id' => '', array(), 
                        array(FALSE, 'No Data to update')),
            array('room_id' => 1, array('room_nae' => 'Class C'), 
                        array(FALSE, 'Update Failed'))
        );
    }

    /**
     * @dataProvider dataRoom
     */
    public function testCreateRoom($data, $expected)
    {
        $tempObj = new Rooms();
        $this->assertContainsOnlyInstancesOf('Rooms', array($tempObj));
        $createStatus = $tempObj->createRoom($data);
        $this->assertEquals($createStatus, $expected);
    
    } 
    /**
     * @dataProvider updateRoom
     */
    public function testUpdateRoom($id, $data, $expected)
    {
        $tempObj = new Rooms();
        $createStatus = $tempObj->updateRoom($data, $id);
        $this->assertEquals($createStatus, $expected[0]);
        $this->assertEquals($tempObj->error, $expected[1]);
    }
   
}
?>
