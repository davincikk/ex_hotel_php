<?php
require_once "RoomType.php";

class RoomTypeTest extends PHPUnit_Framework_TestCase
{

    public function dataRoomType()
    {
        return array(
            array(array('room_type_name' => 'Class A',
                        'capacity' => 2,
                        'features' => 'Test Features',
                        'status' => 'Active',
                        'price' => '1000.00'), TRUE),
            array(array('room_type_name' => 'Class A',
                        'capacity' => 2,
                        'features' => 'Test Features',
                        'status' => 'Active',
                        'price' => '1000.00'), FALSE),
            array(array('room_type_name' => 'Class B',
                        'capacity' => 2,
                        'features' => "'Test Features",
                        'status' => 'Inactive',
                        'price' => '10000.00'), TRUE),
            array(array('room_type_name' => 'Class B',
                        'capacity' => 2,
                        'features' => "'Test Features",
                        'statu' => 'Inactive',
                        'price' => '10000.00'), False)
        );
    } 

    public function updateRoomType()
    {
        return array(
            array('room_type_id' => 1, array('room_type_name' => 'Class C'), 
                        array(TRUE, NULL)),
            array('room_type_id' => 1, array('room_type_name' => 'Class B'), 
                        array(FALSE,'Update Failed')),
            array('room_type_id' => 1, array(), 
                        array(FALSE, 'No Data to update')),
            array('room_type_id' => '', array(), 
                        array(FALSE, 'No Data to update')),
            array('room_type_id' => 1, array('room_type_nae' => 'Class C'), 
                        array(FALSE, 'Update Failed'))
        );
    }

    public function getRoomTypeId()
    {
        return array(
                array(1, ""),
                array(4, "No matching record")
        );
    }

    /**
     * @dataProvider dataRoomType
     */
    public function testCreateRoomType($data, $expected)
    {
        $tempObj = new RoomType();
        $this->assertContainsOnlyInstancesOf('RoomType', array($tempObj));
        $createStatus = $tempObj->createRoomType($data);
        $this->assertEquals($createStatus, $expected);
    }
    
    /**
     * @dataProvider updateRoomType
     */
    public function testUpdateRoomType($id, $data, $expected)
    {
        $tempObj = new RoomType();
        $createStatus = $tempObj->updateRoomType($data, $id);
        $this->assertEquals($createStatus, $expected[0]);
        $this->assertEquals($tempObj->error, $expected[1]);
    }

    public function testgetAllRoomType()
    {
        $tempObj = new RoomType();
        $selectStatus = $tempObj->getAllRoomType();
        $this->assertEquals(count($selectStatus), 2);
    }
    
    public function testgetAllActiveRoomType()
    {
        $tempObj = new RoomType();
        $selectStatus = $tempObj->getAllActiveRoomType();
        $this->assertEquals(count($selectStatus), 1);
    }

    /**
     * @dataProvider getRoomTypeId
     */   
    public function testgetRoomTypeById($id, $expected)
    {
        $tempObj = new RoomType();
        $selectStatus = $tempObj->getRoomTypeById($id);
        $this->assertEquals($tempObj->error, $expected);
    }
}
?>
