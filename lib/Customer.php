<?php
require_once "DBConnection.php";

Class Customer
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

    public function createCustomer($valArray)
    {
        $this->error = null;
        try {
            $crtSt = $this->dbObj->db->prepare("INSERT INTO `customer`(name, 
                email, phone, address1, address2) VALUES (:name, :email, 
                :phone, :address1, :address2)");
            if ($crtSt) {
                $crtStExe = $crtSt->execute([
                    ':name'     => $valArray['name'],
                    ':email'    => $valArray['email'],
                    ':phone'    => $valArray['phone'],
                    ':address1' => $valArray['address1'],
                    ':address2' => $valArray['address2']
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

    public function updateCustomer($updArray, $cust_id)
    {
        $this->error = null;
        try {
            if ((is_array($updArray) && count($updArray)>0) && $cust_id > 0) {
                $setArr  = array();
                $setList = array();
                foreach ($updArray as $key => $value) {
                    $setArr[':'.$key] = $value;
                    $setList[]        = "`" . $key . "` = :" . $key ;
                }
                $setArr[':cust_id'] = $cust_id;

                $setList = implode(",", $setList);
                $updSt   = $this->dbObj->db->prepare("UPDATE `customer` SET " .
                    $setList . " WHERE cust_id = :cust_id");
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

    public function getAllCustomer()
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `customer`");
        if ($selSt) {
            $selStExe = $selSt->execute();
        }
        if ($selStExe) {
            $resSel = $selSt->fetchAll();
            return $resSel;
        }
    }

    public function getCustomerById($custId)
    {
        $this->error = null;

        $selSt = $this->dbObj->db->prepare("SELECT * FROM `customer` 
                    WHERE cust_id = :cust_id");

        $setArr[":cust_id"] = $custId;
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
