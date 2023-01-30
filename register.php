<?php
 include_once "dbconn.php";
 include_once "functions.php";
 include_once "classes.php";
 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register</title>
	<link rel="stylesheet" href="registration.css">
</head>
<?php include "header.php"?>
<body>
<main class="row" style="padding-top: 1vw;">

<div>
    <form action="updation.php" method="post">
    <h3 align="center">CHOOSE MODULES YOU'LL BE DOING THIS SEMESTER</h3>
<?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
?>
<hr>

<?php
    $student = new Student($_SESSION['id']);
    $course = new Course($student->courseId);

    foreach ($course->modules as $key => $value) {
        $module = new Module($value['id']);
        if(!in_array($module->id, $student->doneModules)){
?>
        <input type="checkbox" name="modules[]" id="<?php echo $module->id ?>" value="<?php echo $module->id ?>"><?php echo $module->code ?>: <?php echo $module->name ?><br>

<?php
        }
    }
    if(!empty($student->doneModules)){
?>
    <h5 align="center">THESE ARE MODULES YOU HAVE DONE ALREADY, RE-CHOOSING THEM MEANS THAT THEY ARE RETAKES</h5><hr>
<?php
    foreach ($course->modules as $key => $value) {
        $module = new Module($value['id']);
        if(in_array($module->id, $student->doneModules)){
?>
        <input type="checkbox" name="modules[]" id="<?php echo $module->id ?>" value="<?php echo $module->id ?>"><?php echo $module->code ?>: <?php echo $module->name ?><br>

<?php
        }
    }
}
?>
    <p text-color="#000000">The modules you chose here are the ones you shall be doing this semester, by clicking register, you are agreeing to take these modules</p>
            <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
            <input type="submit" value="REGISTER" name="registerSub" align="center">
    </form>
</div>
</main>
<footer class="row">
	<?php include "footer.php"?>
</footer>

</body>
</html>