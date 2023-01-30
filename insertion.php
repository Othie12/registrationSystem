<?php
 include "dbconn.php";
 include "functions.php";


/************************************** inserting data from the staff page to database *********************************/
if(isset($_POST['staff_sub'])){
 $sname = testInput($_POST['sname']);
 $mname = testInput($_POST['mname']);
 $lname = testInput($_POST['lname']);
 $uname = $_POST['uname'];
 $email = testInput($_POST['email']);
 $tel = testInput($_POST['tel']);
 $sex = testInput($_POST['sex']);
 $dept = testInput($_POST['dept']);
 $pwd = $_POST['pwd'];
 $pwdr = $_POST['pwdr'];

 if($pwd == $pwdr && !empty($pwd)){
    $stmt = $conn->prepare('INSERT INTO staff(sname, mname, lname, uname, sex, contact, email, department, pwd) VALUES(:sname, :mname, :lname, :uname, :sex, :contact, :email, :dept, :pwd)');
    $stmt->bindParam(':sname', $sname);
    $stmt->bindParam(':mname', $mname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':uname', $uname);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':contact', $tel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':dept', $dept);
    $stmt->bindParam(':pwd', $pwd);

    if($stmt->execute())
    header('Location: staff_reg.php?error=inserted successfully');
    else
    header("Location: staff_reg.php?error=something went wrong, your data didn't get inserted");
 }elseif($pwd != $pwdr){
    header("Location: staff_reg.php?error=Your passwords don't match, please recheck them");
 }
    $conn = null;
}

/*************************************** inserting into applicant database table ***********************************/
if(isset($_POST['admission_sub'])){
 $sname = testInput($_POST['sname']);
 $mname = testInput($_POST['mname']);
 $lname = testInput($_POST['lname']);
 $email = testInput($_POST['email']);
 $tel = testInput($_POST['tel']);
 $sex = testInput($_POST['sex']);
 $nin = testInput($_POST['nin']);
 $dob = testInput($_POST['dob']);
 $nationality = testInput($_POST['nationality']);

 $courseId = testInput($_POST['course']);
 $intake = testInput($_POST['intake']);
 $finance = testInput($_POST['finance']);
 $registry = testInput($_POST['registry']);
 $pwd = testInput($_POST['pwd']);
 $dept = 'applicant';

//uploading files
$statusMsg = '';

// File upload path
$targetDir = "images/";

$pptPhoto = basename($_FILES['photo']["name"]);
$id = basename($_FILES["id"]["name"]);
$ple = basename($_FILES["ple"]["name"]);
$uce = basename($_FILES["uce"]["name"]);
$uace = basename($_FILES["uace"]["name"]);
$bankslip = basename($_FILES["bankslip"]["name"]);

$pptPhotoFilePath = $targetDir . $pptPhoto;
$idFilePath = $targetDir . $id;
$pleFilePath = $targetDir . $ple;
$uceFilePath = $targetDir . $uce;
$uaceFilePath = $targetDir . $uace;
$bankslipFilePath = $targetDir . $bankslip;

$pptfileType = pathinfo($pptPhotoFilePath,PATHINFO_EXTENSION);
$idfileType = pathinfo($idFilePath,PATHINFO_EXTENSION);
$plefileType = pathinfo($pleFilePath,PATHINFO_EXTENSION);
$ucefileType = pathinfo($uceFilePath,PATHINFO_EXTENSION);
$uacefileType = pathinfo($uaceFilePath,PATHINFO_EXTENSION);
$bankslipfileType = pathinfo($bankslipFilePath,PATHINFO_EXTENSION);

$quo = '';
if(empty($_FILES["photo"]["name"])){
    $quo = "You'll need to login and complete the form";
}
    $allowTypes = array('jpg','png','jpeg','gif','pdf', '');
    if(in_array($pptfileType, $allowTypes) && in_array($idfileType, $allowTypes) && in_array($plefileType, $allowTypes) && in_array($ucefileType, $allowTypes) && in_array($uacefileType, $allowTypes) && in_array($bankslipfileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $pptPhotoFilePath) && move_uploaded_file($_FILES["id"]["tmp_name"], $idFilePath)
            && move_uploaded_file($_FILES["ple"]["tmp_name"], $pleFilePath) && move_uploaded_file($_FILES["uce"]["tmp_name"], $uceFilePath)
            && move_uploaded_file($_FILES["uace"]["tmp_name"], $uaceFilePath) && move_uploaded_file($_FILES["bankslip"]["tmp_name"], $bankslipFilePath)){
            }else{
                $quo = "but some files were empty.";
            }
            // Insert image file name into database
            $stmt = $conn->prepare('INSERT INTO applicant(sname, mname, lname, sex, dob, nationality, email, id_ppt_no, contact, id_pic, ppt_photo, course_id, ple, uce, uace, intake, bankslip, finance, registry, reg_date, pwd, dept)
             VALUES(:sname, :mname, :lname, :sex, :dob, :nationality, :email, :nin, :contact, :idphoto, :pptphoto, :courseid, :ple, :uce, :uace, :intake, :bankslip, :finance, :registry, NOW(), :pwd, :dept)');
            $stmt->bindParam(':sname', $sname);
            $stmt->bindParam(':mname', $mname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':sex', $sex);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':nationality', $nationality);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nin', $nin);
            $stmt->bindParam(':contact', $tel);
            $stmt->bindParam(':idphoto', $id);
            $stmt->bindParam(':pptphoto', $pptPhoto);
            $stmt->bindParam(':courseid', $courseId);
            $stmt->bindParam(':ple', $ple);
            $stmt->bindParam(':uce', $uce);
            $stmt->bindParam(':uace', $uace);
            $stmt->bindParam(':intake', $intake);
            $stmt->bindParam(':bankslip', $bankslip);
            $stmt->bindParam(':finance', $finance);
            $stmt->bindParam(':registry', $registry);
            $stmt->bindParam(':pwd', $pwd);
            $stmt->bindParam(':dept', $dept);

            if($stmt->execute()){
                $statusMsg = "Thank you ".$sname." ".$lname.", your data will be viewd by the registrar and the finance department {$quo}";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
/*
            $to = $email;
            $subject = 'Limkokwing registration info';
            $message = $statusMsg;

            $success = $mail($to, $subject, $message);
            if($success){
                $notee = 'An email has been sent to you, go check and swiftly';
            }else{
                $notee = 'Their was a problem sending the email';
            }
*/
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }

$conn = null;
// Display status message
echo '<h3>'.$statusMsg.'</h3>';
//header('Location: index.php?');

}

/***************************************** Inserting a faculty **************************************/
if(isset($_POST['add_fac'])){
    $code = testInput($_POST['code']);
    $name = testInput($_POST['name']);

    $stmt = $conn->prepare('INSERT INTO `faculty`(`code`, `name`) VALUES(:code, :nam)');

    if($stmt->execute([':code' => $code, ':nam' => $name]))
    header('Location: academia.php?error=inserted successfully');
    else
    header("Location: academia.php?error=something went wrong, your data didn't get inserted");
  
    $conn = null;
}


/*****************************************  Inserting a course  **************************************/
if(isset($_POST['add_course'])){
    $code = testInput($_POST['code']);
    $name = testInput($_POST['name']);
    $fac = testInput($_POST['fac']);
    $duration = $_POST['durationValue'] .''. $_POST['durationUnits'];
    $type = testInput($_POST['type']);

    $stmt = $conn->prepare('INSERT INTO `course`(`code`, `name`, `fac_id`, `duration`, `type`) VALUES(:code, :nam, :fac, :duration, :typ)');

    if($stmt->execute([':code' => $code, ':nam' => $name, ':fac' => $fac, ':duration' => $duration, ':typ' => $type]))
    header('Location: academia.php?error=inserted successfully');
    else
    header("Location: academia.php?error=something went wrong, your data didn't get inserted");
  
    $conn = null;
}


/****************************************   Inserting a module  *********************************** */
if(isset($_POST['add_module'])){
    $moduleCode = testInput($_POST['code']);
    $moduleName = testInput($_POST['name']);
    $semester = testInput($_POST['sem']);
    $year = testInput($_POST['yr']);

    if(isset($_POST['course'])){
    $courses = $_POST['course'];
    }

    $stmt = $conn->prepare('INSERT INTO `module`(`code`, `name`) VALUES(:code, :nam)');
    $stlt = $conn->prepare('INSERT INTO `module_course`(`module_id`, `course_id`, `semester`, `year`) VALUES(:moduleId, :courseId, :semester, :yr)');

    $conn->beginTransaction();
    if($stmt->execute([':code' => $moduleCode, ':nam' => $moduleName])){
        $lastId = $conn->lastInsertId();

        if(empty($courses)){
            header("Location: academia.php?error=You need to select a course atleast to which this module belongs");
        }else{
        foreach($courses as $course){
            $stlt->execute([':moduleId' => $lastId, ':courseId' => $course, ':semester' => $semester, ':yr' => $year]);
        }
        }
        $conn->commit();
        header('Location: academia.php?error=inserted successfully');
    }else{
        $conn->rollback();
        header("Location: academia.php?error=something went wrong, your data didn't get inserted");
    }
        $conn = null;
}



/****************************************** Inserting a functional fee ***********************************************/
if (isset($_POST['funcfee_sub'])) {
    $feeName = testInput($_POST['feename']);
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];
    $intervals = $_POST['intervals'];

    $stmt = $conn->prepare('INSERT INTO `functional_fee`(`fee_name`, `fee`, `currency`, `intervals`) VALUES(:nam, :amount, :currency, :intervals)');
    if($stmt->execute([':nam' => $feeName, ':amount' => $amount, ':currency' => $currency, 'intervals' => $intervals])){
        header('Location: academia.php?error=inserted successfully');
    }else
    header("Location: academia.php?error=something went wrong, your data didn't get inserted");
    $conn = null;

}

/*********************************************** submitting a timetable **************************************** */
if(isset($_POST['tt_sub'])){
$fac = $_POST['fac'];
$yr = $_POST['yr'];
$sem = $_POST['sem'];

//uploading files
$statusMsg = '';

// File upload path
$targetDir = "timetables/";
$tt = basename($_FILES['tt']["name"]);
$filePath = $targetDir . $tt;
$fileType = pathinfo($filePath,PATHINFO_EXTENSION);
if(!empty($_FILES['tt']["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["tt"]["tmp_name"], $filePath)){
            // Insert image file name into database
            $stmt = $conn->prepare('INSERT INTO timetable(fac_id, sem, yr, tt) values(:fac, :sem, :yr, :tt)');
            
            $stmt->bindParam(':fac', $fac);
            $stmt->bindParam(':sem', $sem);
            $stmt->bindParam(':yr', $yr);
            $stmt->bindParam(':tt', $tt);

            if($stmt->execute()){
                $statusMsg = "Timetable uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}
$conn = null;
// Display status message
header("Location: academia.php?error={$statusMsg}");
}