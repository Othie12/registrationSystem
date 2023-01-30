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

    <style>
        div .pic{
            background-color: rgba(222, 222, 255, 0.507);
            border-radius: 2vw;
            margin-bottom: 1vw;
        }
        div .pic img{
            border-bottom-left-radius: 2vw;
            border-bottom-right-radius: 2vw;
        }
        div .pic h2{
            padding: 2vw;
            margin: 0;
            text-decoration: underline;
        }
    </style>

</head>

<?php include "header.php"?>
<body>
<main class="row">

<h1 align="center" style="text-decoration: underline;"><?php echo $_GET['names'] ?></h1>

<div class="col-2 col-sm-12"></div>


    <?php
        if (isset($_GET['id'])) 
            $id = $_GET['id'];
            
            $st = new Student($id);
    ?>


    <div class="col-8 col-sm-12">
<div class="view">
        <div align="center">
		    <img src='<?php echo "images/{$st->pptPhoto}" ?>' alt="dp" width="50vw" style="border-radius: 10px">
        </div>


<?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
        ?>
        
        <hr>

        <?php
        if ($_SESSION['dept'] == "finance") {
            $stmt = $conn->prepare('SELECT id, sname, mname, lname, reg_date FROM applicant WHERE dept = :dept AND finance = :finance ORDER BY reg_date desc');
            $stmt->execute([':dept' => 'applicant', ':finance' => 'p']);

        }elseif ($_SESSION['dept'] == "registry"){
            $stmt = $conn->prepare('SELECT mod_id, semester, `year`, `date` FROM student_module WHERE stdnt_id = :id');
            $stmt->execute([':id' => $id]);

            ?>
            <table>
                <h3 align="center"> MODULES REGISTERED FOR</h3>
                <tr>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>REGISTERED DATE</th>
                </tr>
            <?php

            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){ 
                   $module = new Module($row['mod_id']);
            ?>
                <tr>
                <td><?php echo $module->code ?></td>
                <td><?php echo $module->name ?></td>
                <td><?php echo $row['date'] ?></td>
                </tr>
            <?php
         }
        }
         ?>
        </table>
            </div>

<div class="col-1 col-sm-12">
    <a href="regForms.php"><button>BACK</button></a>
</div>

</main>

<footer>
    <?php include "footer.php"?>
</footer> 
</body>
</html>