<?php
require_once "Booking.php";

class BookingTest extends PHPUnit_Framework_TestCase
{

    public function dataBooking()
    {
        return array(
            array(array('room_id' => '1',
                        'from_date' => '2015-11-15',
                        'status' => 'Blocked',
                        'to_date' => '2015-11-17',
                        'cust_id' => 1), TRUE),
            array(array('room_id' => '1',
                        'status' => 'Blocked',
                        'from_date' => '2015-11-14',
                        'to_date' => '2015-11-16',
                        'cust_id' => 2), FALSE),
            array(array('room_id' => '1',
                        'status' => 'Blocked',
                        'from_date' => '2015-11-16',
                        'to_date' => '2015-11-19',
                        'cust_id' => 2), FALSE),
            array(array('room_id' => '1',
                        'status' => 'Blocked',
                        'from_date' => '2015-11-13',
                        'to_date' => '2015-11-14',
                        'cust_id' => 2), TRUE),
            array(array('room_id' => '2',
                        'status' => 'Blocked',
                        'cust_id' => 2), FALSE)
        );
    } 

    public function updateBooking()
    {
        return array(
            array('booking_id' => 1, array('status' => 'Confirmed'), 
                        array(TRUE, NULL)),
            array('booking_id' => 1, array(), 
                        array(FALSE, 'No Data to update')),
            array('booking_id' => '', array(), 
                        array(FALSE, 'No Data to update')),
            array('booking_id' => 1, array('statu' => 'Confirmed'), 
                        array(FALSE, 'Update Failed'))
        );
    }

    public function getBookingId()
    {
        return array(
                array(1, ""),
                array(4, "No matching record")
        );
    }

    public function getBookingStatus()
    {
        return array(
                array("Confirmed", ""),
                array("InActive", "No record matching the status")
        );
    }

    public function getBookingCustomer()
    {
        return array(
                array(1, ""),
                array(4, "No record matching the Customer")
        );
    }

    /**
     * @dataProvider dataBooking
     */
    public function testCreateBooking($data, $expected)
    {
        $tempObj = new Booking();
        $this->assertContainsOnlyInstancesOf('Booking', array($tempObj));
        $createStatus = $tempObj->createBooking($data);
        $this->assertEquals($createStatus, $expected);
    
    } 
    /**
     * @dataProvider updateBooking
     */
    public function testUpdateBooking($id, $data, $expected)
    {
        $tempObj = new Booking();
        $createStatus = $tempObj->updateBooking($data, $id);
        $this->assertEquals($createStatus, $expected[0]);
        $this->assertEquals($tempObj->error, $expected[1]);
    }
   
    public function testgetAllBookings()
    {
        $tempObj = new Booking();
        $selectStatus = $tempObj->getAllBookings();
        $this->assertEquals(count($selectStatus), 2);
    }

    /**
     * @dataProvider getBookingId
     */
    public function testgetBookingById($id, $expected)
    {
        $tempObj = new Booking();
        $selectStatus = $tempObj->getBookingById($id);
        $this->assertEquals($tempObj->error, $expected);
    }

    /**
     * @dataProvider getBookingStatus
     */
    public function testgetBookingsByStatus($id, $expected)
    {
        $tempObj = new Booking();
        $selectStatus = $tempObj->getAllBookingsByStatus($id);
        $this->assertEquals($tempObj->error, $expected);
    }

    /**
     * @dataProvider getBookingCustomer
     */
    public function testgetBookingsByCustomer($id, $expected)
    {
        $tempObj = new Booking();
        $selectStatus = $tempObj->getAllBookingsByCustomer($id);
        $this->assertEquals($tempObj->error, $expected);
    }

}
?>
