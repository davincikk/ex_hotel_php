<?php
require_once "DBConnection.php";

Class Booking
{
    public $dbObj = null;
    public $error = null;

    public function __construct()
    {
        if (is_null($this->dbObj)) {
            $this->dbObj = new DBConnection();
            if (is_null($this->dbObj->db)) {
                $this->error = "DB Connection Failed";
                return false;
            }
        }
    } 

    public function createBooking($valArray)
    {
        $this->error = null;
        try {
            $isAvailable = $this->checkAvailability($valArray['room_id'],
                            $valArray['from_date'], $valArray['to_date']);
            if (!$isAvailable) {
                $this->error = "Room Not Available";
                return false;
            }
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `booking`(room_id, 
                from_date, to_date, cust_id, status) VALUES (:room_id, :from_date, 
                :to_date, :cust_id, :status)");
            if ($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':room_id'      => $valArray['room_id'],
                    ':from_date'    => $valArray['from_date'],
                    ':to_date'      => $valArray['to_date'],
                    ':cust_id'      => $valArray['cust_id'],
                    ':status'       => $valArray['status']
                ]);
                if (!$crtStExe) {
                    $this->error = "Unable to create record";
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            $this->error = "Unable to create record, not enough records";
            return false;
        }
    }

    public function updateBooking($updArray, $booking_id)
    {
        $this->error = null;
        try {
            if ((is_array($updArray) && count($updArray)>0) && $booking_id > 0) {
                $setArr  = array();
                $setList = array();
                foreach ($updArray as $key => $value) {
                    $setArr[':'.$key] = $value;
                    $setList[]        = "`" . $key . "` = :" . $key ;
                }
                $setArr[':booking_id'] = $booking_id;

                $setList = implode(",", $setList);
                $updSt   = $this->dbObj->db->prepare("UPDATE `booking` SET " .
                    $setList . " WHERE booking_id = :booking_id");
                if ($updSt) {
                    $updStExe = $updSt->execute($setArr);
                }
                if (!$updStExe) {
                    $this->error = "Update Failed";
                    return false;
                }
                return true;
            } else {
                $this->error = "No Data to update";
                return false;
            }
        } catch (Exception $e) {
            $this->error = "Unable to update record";
            return false;
        } 
    }

    public function getAllBookings()
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `booking`");
        if ($selSt) {
            $selStExe = $selSt->execute();
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            return $resSel;
        }
    }

    public function getAllBookingsByStatus($status)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `booking` 
                    WHERE status = :status");

        $setArr[":status"] = $status;
        if ($selSt) {
            $selStExe = $selSt->execute($setArr);
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            if (count($resSel) == 0 ) {
                $this->error = "No record matching the status";
                return false;
            } else {
                return $resSel;
            }
        }
    }
    
    public function getAllBookingsByCustomer($custId)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `booking` 
                    WHERE cust_id = :cust_id");

        $setArr[":cust_id"] = $custId;
        if ($selSt) {
            $selStExe = $selSt->execute($setArr);
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            if (count($resSel) == 0 ) {
                $this->error = "No record matching the Customer";
                return false;
            } else {
                return $resSel;
            }
        }
    }

    public function getBookingById($bookingId)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `booking` 
                    WHERE booking_id = :booking_id");

        $setArr[":booking_id"] = $bookingId;
        if ($selSt) {
            $selStExe = $selSt->execute($setArr);
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            if (count($resSel) == 0 ) {
                $this->error = "No matching record";
                return false;
            } else {
                return $resSel;
            }
        }
    }

    public function checkAvailability($roomId, $from, $to)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `booking` 
                    WHERE room_id = :room_id and from_date < :to_date 
                    and to_date > :from_date");

        $setArr[":room_id"]   = $roomId;
        $setArr[":from_date"] = $from;
        $setArr[":to_date"]   = $to;
        if ($selSt) {
            $selStExe = $selSt->execute($setArr);
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            if (count($resSel) == 0 ) {
                return true;
            } else {
                return false;
            }
        }
    }

}
