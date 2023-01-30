<?php include_once 'dbconn.php' ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="registration.css">

</head>

<?php include_once "header.php"?>
<body>
<main class="row">

    <div class="col-2 col-sm-12"></div>

    <div class="col-8 col-sm-12 view">

        <div align="center">
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>

        <h3 align="center">ADMISSION FORMS</h3>
        
        <?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
        ?>
        
        <hr>

        <table align="center">
            <tr>
                <th>SURNAME</th>
                <th>MIDDLE NAME</th>
                <th>LAST NAME</th>
                <th>REGISTRATION DATE</th>
            </tr>
        <?php
        if ($_SESSION['dept'] == "finance") {
            $stmt = $conn->prepare('SELECT id, sname, mname, lname, reg_date FROM applicant WHERE dept = :dept AND finance = :finance ORDER BY reg_date desc');
            $stmt->execute([':dept' => 'applicant', ':finance' => 'p']);

        }elseif ($_SESSION['dept'] == "registry"){
            $stmt = $conn->prepare('SELECT id, sname, mname, lname, reg_date FROM applicant WHERE dept = :dept AND finance = :finance ORDER BY reg_date desc');
            $stmt->execute([':dept' => 'applicant', ':finance' => 'a']);

        }
            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){ 
                ?>  
            <tr>
                <td> <?php echo $row['sname']?></td>
                <td> <?php echo $row['lname']?></td>
                <td> <?php echo $row['mname']?></td>
                <td> <?php echo $row['reg_date']?></td>
                <td> <a href="viewApplicant.php?id=<?php echo $row['id']?>"><button>VIEW</button></a> </td>
            </tr>
        <?php
            }
        ?>
        </table>
            
    </div>

    <div class="col-2 col-sm-12"></div>

</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>