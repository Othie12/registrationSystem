<?php
 include_once "dbconn.php";
 include_once "functions.php";
 include_once "classes.php";
 ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Limkokwing courses</title>
	<link rel="stylesheet" href="registration.css">
</head>
<?php include "header.php"?>
<body>
<main class="row" style="padding-top: 1vw;">

<?php
    $id = $_GET['id'];
    $course = new Course($id);
?>

<div>
    <h1 align="center" style="text-decoration: underline;"><?php echo $course->name ?></h1>
    <table align="center">
<?php
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

    
    for ($y = 1; $y <= $time; $y++){
        for($s = 1; $s <= 2; $s++){
?>
<tr>
    <th align="center" style="background-color: lightblue; color: black; padding: 10px; margin-top: 5px;">Year <?php echo $y?>: Semester <?php echo $s ?></th>
</tr>
<?php

for($i = 0; $i < count($course->modules); $i++){

    if($course->modules[$i]['semester'] == $s && $course->modules[$i]['year'] == $y){
        $module = new Module($course->modules[$i]['id']);
?>
    <tr>
        <td><?php echo $module->code .': '. $module->name ?></td>
    </tr>

<?php
        }
    }
    }
}

?>
</table>


<h1 align="center" style="text-decoration: underline;">FUNCTIONAL FEES</h1>
<table align="center">
<tr>
    <th align="center" style="background-color: lightgreen; color: black; padding: 10px;">NAME</th>
    <th align="center" style="background-color: lightgreen; color: black; padding: 10px;">FEE</th>
    <th align="center" style="background-color: lightgreen; color: black; padding: 10px;">PAID EVERY</th>
</tr>

<?php
$stmt = $conn->prepare('SELECT id FROM functional_fee');
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    $ff = new Functional_fee($row['id']);
    ?>
<tr>
    <td><?php echo $ff->name ?></td>
    <td><?php echo "{$ff->currency}: {$ff->fee}" ?></td>
    <td><?php echo $ff->intervals ?></td>
</tr>
    <?php
}
    ?>

</table>
<div align="center" style="padding: 20px;">
    <a href="admission.php?cid=<?php echo $id ?>" align="center"><button>REGISTER FOR COURSE</button></a>
</div>
</main>
<footer class="row">
	<?php include "footer.php"?>
</footer>

</body>
</html>