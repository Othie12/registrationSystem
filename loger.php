<?php
 session_start();
 include "dbconn.php";
 include "functions.php";
 include "classes.php";

 /****************************************** staff member has logged in ********************************************************** */
if(isset($_POST['staffLogin'])){
 $uname = $_POST['uname'];
 $pwd = $_POST['pwd'];
 echo "<h3 align='center'>{$uname}</h3>";
 echo "<h3 align='center'>{$pwd}</h3>";
 
    $staff = new Staff();//the real handler code is held in the Staff class in classes.php page
    if($staff->selectByUname($uname, $pwd)){//using the selectByUname method of the Staff class to get all the info
        $_SESSION['dept'] = $staff->dept;

        $_SESSION['loggedIn'] = true;
        header('Location: adforms.php');

    }else{
        header("Location: login.php?stafferror=wrong username or password&form=staff");
    }
}
/****************************************** if an applicant has logged in ********************************************************** */
if(isset($_POST['applicantLogin'])){
    $sname = $_POST['sname'];
    $lname = $_POST['lname'];
    $pwd = $_POST['pwd'];

    //the login() function is in functions.php which I imported. it handles the login verification
    if(!$id = login($sname, $lname, $pwd)){
        header("Location: login.php?applerror=wrong names or password&form=applicant");       
    }else{

        $appl = new Applicant($id);
        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['dept'] = $appl->dept;
        $_SESSION['dp'] = $appl->pptPhoto;
        if(!empty($appl->msg))
            $_SESSION['msg'] = $appl->msg;
        header('Location: index.php');
    }
}

/****************************************** student has logged in ********************************************************** */
if(isset($_POST['studentLogin'])){
    $stdntNo = $_POST['id_no'];
    $pwd = $_POST['pwd'];

    $stmt = $conn->prepare('SELECT id FROM `applicant` WHERE `stdnt_no` =:stdntNo AND pwd =:pwd AND dept = "student"');
    $stmt->execute([':stdntNo'=>$stdntNo, ':pwd'=>$pwd]);

    $row = $stmt->fetch();
    $count = $stmt->rowcount();

    if($count > 0){
        $student = new Student($row['id']);
        $_SESSION['loggedIn'] = true;       
        $_SESSION['dept'] = "student";
        $_SESSION['id'] = $row['id'];
        $_SESSION['dp'] = $student->pptPhoto;
        if(!empty($student->msg))
            $_SESSION['msg'] = $student->msg;
        header('Location: index.php');
    }else{
        header("Location: login.php?stderror=wrong student number or password&form=student");         
    }
}