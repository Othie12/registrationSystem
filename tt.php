<html lang="en">
    <?php 
    include_once "classes.php";
    include_once "dbconn.php";
    ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="registration.css">

</head>

<?php include "header.php"?>
<body>
<main class="row" align="center">

<h1 align="center" style="text-decoration: underline;">TIME TABLES</h1>

   
<?php
    $student = new Student($_SESSION['id']);
    $course = new Course($student->courseId);
    $fac = new Faculty($course->faculty);
    $stmt = $conn->prepare('SELECT id FROM timetable WHERE fac_id = :fac ORDER BY id DESC');
    $stmt->execute([':fac' => $course->faculty]);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
        $tt = new tt($row['id']);
?>
    <div class="col-2 col-sm-12"></div>
    <div class="col-6 col-sm-12" align="center">
            <article class="framer">
                <div class="dh" >
                    <h3 align="center" style="color: red;"><b><?php echo $fac->name ?></b></h3>
                </div>
                <div class="cont">

                <table class="no">
                    <tr>
                        <th>Semester</th>
                        <td><?php echo $tt->sem ?></td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td><?php echo $tt->yr ?></td>
                    </tr>
                    <tr>
                        <th>Posted on</th>
                        <td><?php echo $tt->date ?></td>
                    </tr>
                </table>
<!--

                <table>
                    <tr>
                        <th>Semester</th>
                        <th>Year</th>
                        <th>Posted</th>
                    </tr>
                    <tr>
                        <td><?php //echo $tt->sem ?></td>
                        <td><?php //echo $tt->yr ?></td>
                        <td><?php //echo $tt->date ?></td>
                    </tr>
                </table>
                -->

                <a href='<?php echo "timetables/{$tt->tt}" ?>'><button>VIEW TIMETABLE</button></a>
                </div>
            </article>
    </div>
    <div class="col-2 col-sm-12"></div>

<?php } ?>
</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>