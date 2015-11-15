<?php
require_once "DBConnection.php";

Class Rooms
{
    public $dbObj = null;
    public $error = null;

    public function __construct()
    {
        if(is_null($this->dbObj)) {
            $this->dbObj = new DBConnection();
            if(is_null($this->dbObj->db)) {
                $this->error = "DB Connection Failed";
                return FALSE;
            }
        }
    } 

    public function createRoom($valArray)
    {
        try {
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `rooms`(room_name, 
                room_type_id, status) VALUES (:room_name, :room_type_id, 
                :status)");
            if($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':room_name' => $valArray['room_name'],
                    ':room_type_id'       => $valArray['room_type_id'],
                    ':status'         => $valArray['status']
                ]);
                if(!$crtStExe) {
                    return FALSE;
                }
            }
            return TRUE;
        } catch (Exception $e) {
            $this->error = "Unable to create record";
            return FALSE;
        }
    }

    public function updateRoom($updArray, $room_id)
    {
       try {
            if((is_array($updArray) && count($updArray)>0) || $room_id > 0) {
                $setArr   = array();
                $setList  = array();
                foreach($updArray as $key => $value) {
                    $setArr[':'.$key] = $value;
                    $setList[] = "`" . $key . "` = :" . $key ;
                }
                if(count($setArr) == 0) {
                    $this->error = "Not Enough data to update record";
                    return FALSE;
                }
                $setArr[':room_id'] = $room_id;
                $setList = implode(",", $setList);
                $updSt = $this->dbObj->db->prepare("UPDATE `rooms` SET " .
                    $setList . " WHERE room_id = :room_id");
                if($updSt) {
                    $updStExe = $updSt->execute($setArr);
                }
                if(!$updStExe) {
                    $this->error = "Update Failed";
                    return FALSE;
                }
                return TRUE;
            } else {
                $this->error = "No Data to update";
                return FALSE;
            }
        } catch (Exception $e) {
            $this->error = "Unable to update record";
            return FALSE;
        } 
    }
}
