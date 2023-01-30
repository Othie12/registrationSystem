<?php
include_once "dbconn.php";

function testInput($data){//function to remove backslashes, whitespaces and the like so that we get data that won't intoxicate our db
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(' ', '_', $data);
    return $data;
    }

    //enable an applicant to login
function login($sname, $lname, $pwd){
    global $conn;
    $stmt = $conn->prepare('SELECT id FROM applicant WHERE sname = :sname AND lname = :lname AND pwd = :pwd');
    $stmt->execute([':sname' => $sname, ':lname' => $lname, ':pwd' => $pwd]);

    $row = $stmt->fetch();
    $count = $stmt->rowcount();

    if($count > 0){
        return $row['id'];
    }else{
        return false;
    }

    $conn = null;
}

#sending an error message to the applicant from the staff(registrar / finance)
function sendMsg2appl($id, $messo){
    global $conn;
    $stmt = $conn->prepare('UPDATE applicant SET msg = :msg WHERE id = :id');
    return $stmt->execute([':msg' => $messo, ':id' => $id])? true : false ;//return true if successfully sent and false othewise

    $conn = null;//close the connection
}