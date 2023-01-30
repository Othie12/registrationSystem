<?php
 session_start();
 include "dbconn.php";
 include "functions.php";
 include "classes.php";


 /************************** If any message  is being sent to an applicant or student ****************************/
 if(isset($_POST['message_sub'])){
    $message = testInput($_POST['message']);
    $id = $_POST['id'];

    if(sendMsg2appl($id, $message)){//handler code in functions.php
        header('Location: viewApplicant.php?error=sent successfully&id='.$id.'');
    }
 }

 /**************************** If the registrar has decided to admit someone **************************************************** */
 if(isset($_POST['admit_sub'])){
    $id = $_POST['id'];
    $stdntNo = testInput($_POST['stdntNo']);
    $arrivalDate = $_POST['arrival_date'];
    $sname = $_POST['sname'];
    $lname = $_POST['lname'];
    $course = $_POST['course'];
    $msg = str_replace(' ', '_', "CONGRATULATIONS <br>Hello {$sname} {$lname} Limkokwing University would like to inform you that you have been given a place in
    the {$course} course.<br>Your new student number is <b>{$stdntNo}</b>, you are therefore expected to arrive at campus ready for studies before <b>{$arrivalDate}</b>.");

    $stmt = $conn->prepare('UPDATE applicant SET registry = :registry, msg = :msg, dept = "student", stdnt_no = :stdnt_no, admission_date = NOW(), `year` = 1, `semester` = 0 WHERE id = :id');
    if($stmt->execute([':registry' => 'a', ':msg' => $msg, ':id' => $id, ':stdnt_no' => $stdntNo])){
        header('Location: adforms.php?error='.$sname.' '.$lname.' has got admitted&id='.$id.'');
    }else{
        header('Location: viewApplicant.php?error=Sorry, we encountered a problem, try re-admiting this applicant&id='.$id.'');
    }
 }

 /*********************** If someone from the finance dept has set tuition ************************************************************** */
 if(isset($_POST['tuition_sub'])){
    $tuition = $_POST['tuition'];
    $id = $_POST['id'];
    //$currency = $_POST['currency'];

    $stmt = $conn->prepare('UPDATE course SET tuition = :tuition WHERE id = :id');
    if($stmt->execute([':tuition' => $tuition, ':id' => $id])){
        header('Location: academia.php?error=Updated succesfully');
    }else{
        header('Location: academia.php?error=Something went wrong');
    }
 }


 /************************** for students who are registering for a new semester ***************************/
 if(isset($_POST['registerSub'])){
    $id = $_POST['id'];

    $student = new Student($_SESSION['id']);
    $course = new Course($student->courseId);

//we re first checking the time of the course this person does via tha Course class in classes.php
    switch ($course->duration) {
        case '1 year':
            $time = 1;
            break;
        
        case '2 years':
            $time = 2;
            break;
        
        case '3 years':
            $time = 3;
            break;
        
        case '4 years':
            $time = 4;
            break;
        
        default:
            $time = 1;
            break;
    }
        $y = $student->year;
        $s = $student->semester;

//making sure the student's semester and year gets incremented every when they register acourdingly
    if($y < $time || ($s == 1 && $y == $time)) {//but they shouldnt exceed their coursetime.
            if($s < 2 || ($s == 1 && $y == $time)) {
                $s++;
            }else{
                $s = 1;
                $y++;
            }

    if(isset($_POST['modules'])){
        $modules = $_POST['modules'];
    }
    if(empty($modules)){
        $php_errormsg="No modules selected";
    }elseif(!isset($php_errormsg)){
            $bar = $conn->prepare("INSERT INTO student_module(stdnt_id, mod_id, semester, `year`, `date`) VALUES(:stdntId, :modId, :sem, :yr, CURDATE())");
            $foo = $conn->prepare("UPDATE applicant SET semester = :sem, `year` = :yr WHERE id = :id");

            $conn->beginTransaction();
            foreach($modules as $mod){
            $bar->bindParam(':modId', $mod);
            $bar->bindParam(':stdntId', $id);
            $bar->bindParam(':sem', $s);
            $bar->bindParam(':yr', $y);
            if($bar->execute()){
                if($foo->execute([':id' => $id, ':sem' => $s, ':yr' => $y])){
                    $php_errormsg = "Registration successful";
                }
            }
        }
        $conn->commit();
    }
    $err = $php_errormsg;

}else {
    //send this error if the student has finished their last year and they are still registering;
    $err = "It seems that you have completed your last year in the university since you were doing a {$course->duration} course";
 }
    header("Location: register.php?error={$err}");
 }

 /******************************************** if an applicant has pressed update sub1 to update info***************** */
 if(isset($_POST['update_sub1'])){
    $id = $_POST['id'];
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

    $stmt = $conn->prepare('UPDATE applicant SET sname = :sname, mname = :mname, lname = :lname, email = :email, contact = :tel, sex = :sex, id_ppt_no = :nin, dob = :dob, nationality = :nationality, course_id = :course_id, intake = :intake WHERE id = :id');
    $stmt->bindParam(':sname', $sname);
    $stmt->bindParam(':mname', $mname);
    $stmt->bindParam(':lname', $lname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':nin', $nin);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':course_id', $courseId);
    $stmt->bindParam(':intake', $intake);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        header("Location: edit.php?error=updated successfully");
    }else{
        header("Location: edit.php?error=failed to update");
    }
 }

 /******************************************* if applicant has clicked update sub_2 ********************************** */
 if(isset($_POST['update_sub2'])){
    $item = $_POST['key'];
    $val = basename($_FILES['val']['name']);
    $id = $_POST['id'];

    $stlt = $conn->prepare('SELECT `'.$item.'` FROM applicant WHERE id = :id');
    $stlt->execute([':id' => $id]);
    $row = $stlt->fetch();
        $toDelete = $row[0];
/*
        if(!empty($toDelete)){
            unlink($toDelete);
        }
*/
        $targetDir = "images/";
        $filePath = $targetDir . $val;
        $fileType = pathinfo($filePath,PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif','pdf', '');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["val"]["tmp_name"], $filePath)){
                $stmt = $conn->prepare('UPDATE applicant SET `'.$item.'` = :val WHERE id = :id');
                if($stmt->execute([':val' => $val, ':id' => $id])){
                    $quo = "Updated successfuly";
                }else{
                    $quo = "Error inserting to database";
                }
            }else{
                $quo = "File upload failed.";
            }
 }else{
    $quo = "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
 }
 header("Location: edit.php?error=$quo");
}