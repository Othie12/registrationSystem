<?php
 include "dbconn.php";
 include "functions.php";
 include "classes.php";
 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<link rel="stylesheet" href="registration.css">
</head>
<?php include "header.php"?>
<body>
<main class="row" style="padding-top: 1vw;">
<?php
$stt = $conn->prepare('SELECT id FROM faculty');
$stt->execute();

while($faculty = $stt->fetch(PDO::FETCH_ASSOC) ){

    $fac = new Faculty($faculty['id']);

    ?>
    <div class="dhv col-12 col-sm-12">
        <h1 align="center"><?php echo $fac->name ?></h1><hr>
    </div>
<!--
    <article class="cont">
    <div class="col-2 col-sm-12">
-->
    <?php 
        foreach($fac->courses as $course){
            $course = new Course($course)
        
    ?>
    <div class="col-2 col-sm-6">
            <article class="framer">
                <div class="dh" >
                    <h3 align="center" style="color: red;"><?php echo $course->name ?></h3>
                </div>
                <div class="cont">
				<p><b>Duration: </b><?php echo $course->duration ?></p>
				<p><b>Tuition: </b><?php echo $course->tuition ?></p>
				<p><b>Type: </b><?php echo $course->type ?></p>
                <a href="viewcourse.php?id=<?php echo $course->id ?>"><button>VIEW MORE</button></a>
                </div>
            </article>
    </div>
    <?php
        }
}
    


?>
</main>
<footer class="row">
	<?php include "footer.php"?>
</footer>

</body>
</html>