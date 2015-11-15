<?php
require_once "DBConnection.php";

Class Rooms
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

    public function createRoom($valArray)
    {
        $this->error = null;
        try {
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `rooms`(room_name, 
                room_type_id, status) VALUES (:room_name, :room_type_id, 
                :status)");
            if ($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':room_name' => $valArray['room_name'],
                    ':room_type_id'       => $valArray['room_type_id'],
                    ':status'         => $valArray['status']
                ]);
                if (!$crtStExe) {
                    return false;
                }
            }
            return true;
        } catch (Exception $e) {
            $this->error = "Unable to create record";
            return false;
        }
    }

    public function updateRoom($updArray, $room_id)
    {
        $this->error = null;
        try {
            if ((is_array($updArray) && count($updArray)>0) && $room_id > 0) {
                $setArr  = array();
                $setList = array();
                foreach ($updArray as $key => $value) {
                    $setArr[':'.$key] = $value;
                    $setList[]        = "`" . $key . "` = :" . $key ;
                }
                $setArr[':room_id'] = $room_id;

                $setList = implode(",", $setList);
                $updSt   = $this->dbObj->db->prepare("UPDATE `rooms` SET " .
                    $setList . " WHERE room_id = :room_id");
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

    public function getAllRooms()
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `rooms`");
        if ($selSt) {
            $selStExe = $selSt->execute();
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            return $resSel;
        }
    }

    public function getAllRoomsByStatus($status)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `rooms` 
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
    
    public function getAllRoomsByType($typeId)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `rooms` 
                    WHERE room_type_id = :room_type_id");

        $setArr[":room_type_id"] = $typeId;
        if ($selSt) {
            $selStExe = $selSt->execute($setArr);
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            if (count($resSel) == 0 ) {
                $this->error = "No record matching the type";
                return false;
            } else {
                return $resSel;
            }
        }
    }

    public function getRoomById($roomId)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `rooms` 
                    WHERE room_id = :room_id");

        $setArr[":room_id"] = $roomId;
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

}
