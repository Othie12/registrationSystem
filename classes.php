<?php
include "dbconn.php";

//this is the parent class that is going to hold information about all the users in our system.
//it is inherited by student, staff, applicant classes
class User{
    //it contains some prototypes of attributes that are common
    public $id;
    public $sname;
    public $mname;
    public $lname;
    public $sex;
    public $dob;
    public $nationality;
    public $nin;
    public $tel;
    public $email;
    public $pwd;

    protected function age(){}
}

class Applicant extends User{
    //all the info about an applicant will be gotten via this class.
    public $idPic;
    public $pptPhoto;
    public $ple;
    public $uce;
    public $uace;
    public $intake;
    public $desiredCourseId;
    public $desiredCourse;
    public $finance;
    public $bankSlip;
    public $registry;
    public $regDate;
    public $msg;

    // the constructor takes an id as an argument
    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT a.*, c.name, c.id cid FROM `applicant` a JOIN  course c ON a.course_id = c.id WHERE a.`id` = :id');
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
        //populate all the attributes with data from the db
        if($count > 0){
            $this->id = $row['id'];
            $this->sname = $row['sname'];
            $this->mname = $row['mname'];
            $this->lname = $row['lname'];
            $this->sex = $row['sex'];
            $this->tel = $row['contact'];
            $this->email = $row['email'];
            $this->nationality = $row['nationality'];
            $this->nin = $row['id_ppt_no'];
            $this->dob = $row['dob'];
            $this->idPic = $row['id_pic'];
            $this->pptPhoto = $row['ppt_photo'];
            $this->ple = $row['ple'];
            $this->uce = $row['uce'];
            $this->uace = $row['uace'];
            $this->desiredCourseId = $row['cid'];
            $this->desiredCourse = str_replace( '_', ' ', $row['name']);
            $this->intake = $row['intake'];
            $this->finance = $row['finance'];
            $this->bankSlip = $row['bankslip'];
            $this->registry = $row['registry'];
            $this->regDate = $row['reg_date'];
            $this->msg = $row['msg'];
            $this->dept = $row['dept'];

            return true;
        }else{
            $this->sname = 'unresolved';
            return false;
        }

    }

}

class Staff extends User{
    public $uname;
    public $department;
    public $duty;

    public function getnames(){
        return $this->sname.' '.$this->lname;
     }

    public function selectByUname($uname, $pwd){
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM `staff` WHERE `uname` =:uname AND pwd =:pwd');
        $stmt->execute([':uname'=>$uname, ':pwd'=>$pwd]);

        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if($count > 0){
            $this->id = $row['id'];
            $this->sname = $row['sname'];
            $this->mname = $row['mname'];
            $this->lname = $row['lname'];
            $this->uname = $row['uname'];
            $this->sex = $row['sex'];
            $this->tel = $row['contact'];
            $this->email = $row['email'];
            $this->dept = $row['department'];
            $this->pwd = $row['pwd'];
            return true;
        }else{
            return false;
        }
        
    }

    public function selectById($id){
        $stmt = $conn->prepare('SELECT * FROM `staff` WHERE `id`=:id');
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if($count > 0){
            $this->id = $row['id'];
            $this->sname = $row['sname'];
            $this->mname = $row['mname'];
            $this->lname = $row['lname'];
            $this->uname = $row['uname'];
            $this->sex = $row['sex'];
            $this->tel = $row['contact'];
            $this->email = $row['email'];
            $this->dept = $row['department'];
            $this->pwd = $row['pwd'];
            return true;
        }else{
            return false;
        }
          
    }
}

class Student extends User{
    public $stdntNo;
    public $course;
    public $courseId;
    public $year;
    public $semester;
    public $pptPhoto;
    public $doneModules = array();

    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT a.*, c.id, c.name FROM `applicant` a JOIN  course c ON a.course_id = c.id WHERE a.`id` = :id AND a.dept = :dept');
        $stlt = $conn->prepare('SELECT mod_id id FROM student_module WHERE stdnt_id = :id');

        $conn->beginTransaction();
        $stmt->execute([':id' => $id, ':dept' => 'student']);

        $row = $stmt->fetch();
        $count = $stmt->rowcount();

        if($count > 0){
            $this->id = $row['id'];
            $this->stdntNo = $row['stdnt_no'];
            $this->sname = $row['sname'];
            $this->mname = $row['mname'];
            $this->lname = $row['lname'];
            $this->sex = $row['sex'];
            $this->tel = $row['contact'];
            $this->email = $row['email'];
            $this->nationality = $row['nationality'];
            $this->nin = $row['id_ppt_no'];
            $this->dob = $row['dob'];
            $this->idPic = $row['id_pic'];
            $this->pptPhoto = $row['ppt_photo'];
        /* $this->ple = $row['ple'];
            $this->uce = $row['uce'];
            $this->uace = $row['uace'];*/
            $this->courseId = $row['id'];
            $this->course = str_replace( '_', ' ', $row['name']);
           // $this->intake = $row['intake'];
            $this->finance = $row['finance'];
            $this->bankSlip = $row['bankslip'];
            $this->registry = $row['registry'];
          //  $this->regDate = $row['reg_date'];
            $this->msg = $row['msg'];
            $this->semester = $row['semester'];
            $this->year = $row['year'];
            $this->dept = $row['dept'];

            $stlt->execute([':id' => $id]);

            while($module = $stlt->fetch(PDO::FETCH_ASSOC) )
                $this->doneModules[] = $module['id'];

            $conn->commit();
            return true;
        }else{
            $conn->rollback();
            return false;
        }
    }
}

class Academic_grp{
    public $id;
    public $code;
    public $name;
    public $numberOfStudents = '';

    public function noOfStudents(){}
}

class Faculty extends Academic_grp{
    public $courses = array();

    
   public function __construct($id){
    global $conn;
    $stmt = $conn->prepare('SELECT * FROM faculty WHERE id = :id');
    $stlt = $conn->prepare('SELECT id FROM course WHERE fac_id = :id');
    $stnt = $conn->prepare('SELECT COUNT(a.sname) student_count FROM applicant a JOIN course c ON a.course_id = c.id WHERE c.fac_id = :fac_id AND a.dept = "student"');

    $conn->beginTransaction();
    $stmt->execute([':id' => $id]);
    
    $row = $stmt->fetch();
    $count = $stmt->rowcount();

        if($count > 0){
            $this->id = $row['id'];
            $this->code = $row['code'];
            $this->name = str_replace( '_', ' ', $row['name']);

            $stlt->execute([':id' => $this->id]);
            $stnt->execute([':fac_id' => $this->id]);

            while($course = $stlt->fetch(PDO::FETCH_ASSOC) )
                $this->courses[] = $course['id'];

            $this->numberOfStudents = $stnt->fetch()[0];

            $conn->commit();
            return true;
        }else{

            $conn->rollback();
            return false;
        }
    }
}

class Course extends Academic_grp{
    public $faculty;
    public $tuition;
    public $modules = array();

    private function duration($d){
        if($d == '1y' || $d == '1m' || $d == '1w'){
            $d = str_replace('y', ' year', $d);
            $d = str_replace('m', ' month', $d);
            $d = str_replace('w', ' week', $d);
        }else{
            $d = str_replace('y', ' years', $d);
            $d = str_replace('m', ' months', $d);
            $d = str_replace('w', ' weeks', $d);
        }
        return $d;
    }

    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM course WHERE id = :id');
        $stlt = $conn->prepare('SELECT m.id, mc.semester, mc.year FROM module m JOIN module_course mc ON m.id = mc.module_id WHERE mc.course_id = :id');
        $stnt = $conn->prepare('SELECT COUNT(a.sname) student_count FROM applicant a JOIN course c ON a.course_id = c.id WHERE c.id = :id AND a.dept = :stdnt');

        $conn->beginTransaction();
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
    
            if($count > 0){
                $this->id = $row['id'];
                $this->code = $row['code'];
                $this->faculty = $row['fac_id'];
                $this->tuition = $row['tuition'];
                $this->duration = $this->duration($row['duration']);
                $this->type = $row['type'];
                $this->name = str_replace( '_', ' ', $row['name']);
    
                $stlt->execute([':id' => $this->id]);
                $stnt->execute([':id' => $this->id, ':stdnt' => "student"]);
    
                while($module = $stlt->fetch(PDO::FETCH_ASSOC) )
                    $this->modules[] = $module;
    
                $this->numberOfStudents = $stnt->fetch()[0]; 

                $conn->commit();
                return true;
            }else{
                $conn->rollback();
                return false;
            }
        }
    
}

class Module extends Academic_grp{
    private $courses = array();

    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM module WHERE id = :id');
        $stlt = $conn->prepare('SELECT c.id, mc.semester, mc.year FROM course c JOIN module_course mc ON c.id = mc.course_id WHERE mc.module_id = :id');
        $stnt = $conn->prepare('SELECT COUNT(a.sname) student_count FROM applicant a JOIN course c JOIN module_course mc ON a.course_id = c.id AND c.id = mc.course_id WHERE mc.module_id = :id AND a.dept = "student"');

        $conn->beginTransaction();
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
    
            if($count > 0){
                $this->id = $row['id'];
                $this->code = $row['code'];
                $this->name = str_replace( '_', ' ', $row['name']);
    
                $stlt->execute([':id' => $this->id]);
                $stnt->execute([':id' => $this->id]);
    
                while($course = $stlt->fetch(PDO::FETCH_ASSOC) )
                    $this->courses[] = $course;
    
                $this->numberOfStudents = $stnt->fetch()[0];

                $conn->commit();
                return true; 
            }else{
                $conn->rollback();
                return false;
            }
        }

}

class Functional_fee{
    public $id;
    public $name;
    public $fee;
    public $currency;
    public $intervals;

    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM functional_fee WHERE id = :id');
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
    
            if($count > 0){
                $this->id = $row['id'];
                $this->fee = $row['fee'];
                $this->currency = $row['currency'];
                $this->intervals = $this->interval($row['intervals']);
                $this->name = str_replace( '_', ' ', $row['fee_name']);
                return true;
            }else{
                return false;
            }
        }

    private function interval($interval){
        switch ($interval) {
            case 'once':
                $i = 'Once';
                break;
            
            case 'annual':
                $i = 'Year';
                break;
            
            case 'semester':
                $i = 'Semester';
                break;
            
            default:
                $i = 'Unresolved';
                break;
        }
        return $i;
    }

}

class tt{
    public $id;
    public $fac_id;
    public $sem;
    public $yr;
    public $tt;
    public $date;

    public function __construct($id){
        global $conn;
        $stmt = $conn->prepare('SELECT * FROM timetable WHERE id = :id');
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
    
            if($count > 0){
                $this->id = $row['id'];
                $this->fac_id = $row['fac_id'];
                $this->sem = $this->time($row['sem']);
                $this->yr = $this->time($row['yr']);
                $this->tt = $row['tt'];
                $this->date = $row['date'];
                return true;
            }else{
                return false;
            }
        }

            private function time($t){
                    switch ($t) {
                        case 0:
                            $i = 'All';
                            break;
                        
                        default:
                            $i = $i;
                            break;
                    }
                    return $i;
                }
    
}