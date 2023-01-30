<?php
 include_once 'dbconn.php';
 include_once 'classes.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATION FORMS</title>

    <link rel="stylesheet" href="registration.css">

    <style media="print">
        body {
            visibility: hidden;
        }
        .print{
            visibility: visible;
        }
        table{
            color: black;
        }
        th, td{
            border-style: solid;
            margin: 0;
        }
    </style>
</head>

<?php include_once "header.php"?>
<body>
<main class="row">

    <div class="col-1 col-sm-12"></div>

    <div class="col-10 col-sm-12 print">

        <h1 align="center">REGISTRATION FORMS</h1>
        <a href="export.php?exp=y"><button>EXPORT TO EXCEL SPREADSHEET</button></a>

        <?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
        ?>
        
        <hr>

        <?php
            if(isset($_GET['exp'])){
                header("content-Type: application/xls");
                header("content-Disposition: attachment; filename=table.xls");
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
      /*  if ($_SESSION['dept'] == "finance") {
            $stmt = $conn->prepare('SELECT id, sname, mname, lname, reg_date FROM applicant WHERE dept = :dept AND finance = :finance ORDER BY reg_date desc');
            $stmt->execute([':dept' => 'applicant', ':finance' => 'p']);

        }elseif ($_SESSION['dept'] == "registry"){*///trying to get students who registered and their courses
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
                <td> <a href="viewReg.php?id=<?php echo $row['stdnt_id']?>&names=<?php echo $stdnt->sname.' '.$stdnt->mname.' '.$stdnt->lname?>"><button>VIEW</button></a> </td>
            </tr>
        <?php
            }
        ?>
        </table>
        <?php
           // }

        ?>
            
    </div>

    <div class="col-1 col-sm-12">
        <button onclick="window.print();return false;">PRINT</button>
    </div>

</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>
