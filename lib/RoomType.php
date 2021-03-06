<?php
require_once "DBConnection.php";

Class RoomType
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

    public function createRoomType($valArray)
    {
        try {
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `room_type`
                (room_type_name, capacity, features, status, price) 
                VALUES (:room_type_name, :capacity, 
                :features, :status, :price)");
            if ($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':room_type_name' => $valArray['room_type_name'],
                    ':capacity'       => $valArray['capacity'],
                    ':features'       => $valArray['features'],
                    ':status'         => $valArray['status'],
                    ':price'          => $valArray['price']
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

    public function updateRoomType($updArray, $room_type_id)
    {
        try {
            if ((is_array($updArray) && count($updArray)>0) && $room_type_id > 0) {
                $setArr  = array();
                $setList = array();
                foreach ($updArray as $key => $value) {
                    $setArr[':'.$key] = $value;
                    $setList[]        = "`" . $key . "` = :" . $key ;
                }
                $setArr[':room_type_id'] = $room_type_id;

                $setList = implode(",", $setList);
                $updSt   = $this->dbObj->db->prepare("UPDATE `room_type` SET " .
                    $setList . " WHERE room_type_id = :room_type_id");
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

    public function getAllRoomType()
    {
        $selSt = $this->dbObj->db->prepare("SELECT * FROM `room_type`");
        if ($selSt) {
            $selStExe = $selSt->execute();
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            return $resSel;
        }
    }
    
    public function getAllActiveRoomType()
    {
        $selSt = $this->dbObj->db->prepare("SELECT * FROM `room_type` 
                        WHERE status = 'Active'");
        if ($selSt) {
            $selStExe = $selSt->execute();
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            return $resSel;
        }
    }


    public function getRoomTypeById($typeId)
    {
        $selSt = $this->dbObj->db->prepare("SELECT * FROM `room_type` 
                    WHERE room_type_id = :room_type_id");

        $setArr[":room_type_id"] = $typeId;
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
