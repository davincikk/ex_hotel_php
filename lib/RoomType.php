<?php
require_once "DBConnection.php";

define(TBL_ROOM_TYPE, "room_type");

Class RoomType
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

    public function createRoomType($valArray)
    {
        try {
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `room_type`(room_type_name, 
                capacity, features, status, price) VALUES (:room_type_name, :capacity, 
                :features, :status, :price)");
            if($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':room_type_name' => $valArray['room_type_name'],
                    ':capacity'       => $valArray['capacity'],
                    ':features'       => $valArray['features'],
                    ':status'         => $valArray['status'],
                    ':price'          => $valArray['price']
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

    public function updateRoomType($updArray)
    {
       try {
            if(is_array($updArray) && count($updArray)>0) {
                $where = "";
                $setArr   = array();
                $setList  = array();
                foreach($updArray as $key => $value) {
                    if($key == 'room_type_id') {
                        $where = $value;
                    } else {
                        $setArr[':'.$key] = $value;
                        $setList[] = "`" . $key . "` = :" . $key ;
                    }
                }
                if($where == "" || count($setArr) == 0) {
                    $this->error = "Not Enough data to update record";
                    return FALSE;
                }
                $setArr[':room_type_id'] = $where;
                $setList = implode(",", $setList);
                $updSt = $this->dbObj->db->prepare("UPDATE `room_type` SET " .
                    $setList . " WHERE room_type_id = :room_type_id");
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
