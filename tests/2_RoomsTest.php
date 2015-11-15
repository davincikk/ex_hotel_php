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
                        'room_type_id' => 6), FALSE),
            array(array('room_name' => 'Suite 3',
                        'statu' => 'Cleaning',
                        'room_type_id' => 6), FALSE)
        );
    } 

    public function updateRoom()
    {
        return array(
            array('room_id' => 1, array('room_name' => 'Suite 4'), 
                        array(TRUE, NULL)),
            array('room_id' => 1, array(), 
                        array(FALSE, 'No Data to update')),
            array('room_id' => '', array(), 
                        array(FALSE, 'No Data to update')),
            array('room_id' => 1, array('room_nae' => 'Class C'), 
                        array(FALSE, 'Update Failed'))
        );
    }

    public function getRoomId()
    {
        return array(
                array(1, ""),
                array(4, "No matching record")
        );
    }

    public function getRoomStatus()
    {
        return array(
                array("Occupied", ""),
                array("InActive", "No record matching the status")
        );
    }

    public function getRoomType()
    {
        return array(
                array(1, ""),
                array(4, "No record matching the type")
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
   
    public function testgetAllRoom()
    {
        $tempObj = new Rooms();
        $selectStatus = $tempObj->getAllRooms();
        $this->assertEquals(count($selectStatus), 2);
    }

    /**
     * @dataProvider getRoomId
     */
    public function testgetRoomById($id, $expected)
    {
        $tempObj = new Rooms();
        $selectStatus = $tempObj->getRoomById($id);
        $this->assertEquals($tempObj->error, $expected);
    }

    /**
     * @dataProvider getRoomStatus
     */
    public function testgetRoomsByStatus($id, $expected)
    {
        $tempObj = new Rooms();
        $selectStatus = $tempObj->getAllRoomsByStatus($id);
        $this->assertEquals($tempObj->error, $expected);
    }

    /**
     * @dataProvider getRoomType
     */
    public function testgetRoomsByType($id, $expected)
    {
        $tempObj = new Rooms();
        $selectStatus = $tempObj->getAllRoomsByType($id);
        $this->assertEquals($tempObj->error, $expected);
    }

}
?>
