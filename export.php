<?php
include "dbconn.php";
include "classes.php";
if(isset($_GET['exp'])){
    header("content-Type: application/xls");
    header("content-Disposition: attachment; filename=registered students.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}
?>
<table align="center">
            <tr>
                <th>SURNAME</th>
                <th>LAST NAME</th>
                <th>REGISTRATION NUMBER</th>
                <th>COURSE</th>
                <th>SEMESTER</th>
                <th>YEAR</th>
            </tr>
        <?php
            $stmt = $conn->prepare('SELECT stdnt_id, GROUP_CONCAT(mod_id ORDER BY mod_id DESC) AS modules, semester, `year`, `date` FROM student_module WHERE `date` <= CURDATE() AND `date` >= CURDATE() - INTERVAL 2 MONTH GROUP BY stdnt_id');
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){ 
                $stdnt = new Student($row['stdnt_id']);
                $course = new Course($stdnt->courseId);
                $mods = explode(',', $row['modules']);
                ?>  
            <tr>
                <td> <?php echo $stdnt->sname?></td>
                <td> <?php echo $stdnt->lname?></td>
                <td> <?php echo $stdnt->stdntNo?></td>
                <td> <?php echo $course->code?></td>
                <td> <?php echo $stdnt->semester?></td>
                <td> <?php echo $stdnt->year?></td>
            </tr>
        <?php
            }
        ?>
        </table>
       