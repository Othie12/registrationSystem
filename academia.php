<?php include_once "dbconn.php";
include_once "classes.php";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="registration.css">
    <style>
        form > table{
            width: 100%;
        }
    </style>

</head>
<body>
<?php include "header.php"?>

<main class="row">
    <div class="col-4 col-sm-12">

<?php if($_SESSION['dept'] == "registry"){ ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get" style="background-color: black;">

        <label for="add">What do you want to add?</label>
            <select name="add" id="add">
                <option value="">Choose</option>
                <option value="faculty">Faculty</option>
                <option value="course">Course</option>
                <option value="module">Module</option>
            </select>

            <input type="submit" name="ad" value="Get form">
        </form>


        <form action="insertion.php" method="post" enctype="multipart/form-data" style="background-color: black;">
        <h2 align="center">UPLOAD TIMETABLE</h2><hr>
<?php 
        if (isset($_GET['error'])) {
            echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
        }
?>
        <table>
            <tr>
<?php
$stmt = $conn->prepare('SELECT * FROM faculty');
$stmt->execute();
?>
        <th><label for="fac">Faculty:</label></th>
    
        <td><select name="fac" id="fac" required>
        <option value="">Choose faculty</option>
            <?php
            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                echo '<option value='.$row['id'].'>'.$row['code'].'</option>';
            }
            ?>
        </select></td> 
            </tr>

            <tr>   
                <th><label for="sem">Semester:</label></th> 
                <td><select name="sem" id="s" required>
                        <option value="0">All</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select></td>  
            </tr>
            <tr>
                <th><label for="yr">Year:</label></th>
                <td><select name="yr" id="y" required>
                        <option value="0">All</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select></td>
            </tr>
            <tr>
              <th><label for="tt">Timetable:</label></th>
              <td><input type="file" name="tt" id="" required></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" value="UPLOAD" name="tt_sub"></td>
            </tr>
        </table>
    </form>



<?php }elseif($_SESSION['dept'] == "finance"){ ?>
    <form action="insertion.php" method="post" style="background-color: black;">
        <h2 align="center">ADD FUNCTIONAL FEE</h2><hr>
    <?php 
        if (isset($_GET['error'])) {
            echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
        }
    ?>
        <table class="no">
            <tr>
              <th>
                <label for="feename">Name of functional fee</label><br>
                <input type="text" name="feename" placeholder="Name of functional fee" required>
              </th>
            </tr>
            <tr>
              <th>
                <label for="amount">Amount</label><br>
                <input type="text" name="amount" id="amount" placeholder="50,000" required>
              </th>
            </tr>
            <tr>
              <th>
                <label for="currency">Currency</label><br>
                <input type="radio" name="currency" value="USHS" required>Uganda shillings  
                <input type="radio" name="currency" value="USD" required>US dollar
              </th>
            </tr>
            <tr>
              <th>
                <label for="intervals">Payment intervals</label><br>
                <select name="intervals" id="intervals" required>
                    <option value="">Choose</option>
                    <option value="once">Once</option>
                    <option value="annual">Every year</option>
                    <option value="semester">Every semester</option>
                </select>
              </th>
            </tr>
            <tr>
                <th><input type="submit" value="SUBMIT" name="funcfee_sub"></th>
            </tr>
        </table>
    </form>
<?php } ?>


    </div>
    <div class="col-8 col-sm-12">
    <?php 
        if (isset($_GET['error'])) {
            echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
        }
    ?>
    </div>
    <?php 
    #display the relevant form according to what the regestrar wants to add
        if(isset($_GET['ad'])){

            if($_GET['add'] == "faculty"){
    
                echo '<div class="col-8 col-sm-12">';
                echo '<form action="insertion.php" method="post" >';

                echo '<table>';
                echo '<tr>';
                echo '<th>Faculty code:</th>';
                echo '<th><input type="text" name="code" placeholder="Faculty code" required></th>';
                echo '</tr>';
                echo '<tr>';
                echo '<th>Faculty name:</th>';
                echo '<th><input type="text" name="name" placeholder="Faculty name" required></th>';
                echo '</tr>';
                echo '<tr>';
                echo '<th><input type="submit" name="add_fac" value="Submit"></th>';
                echo '</tr>';
                echo '</table>';

                echo '</form></div>';

            }else if($_GET['add'] == "course"){//form for inserting a new course

                echo '<div class="col-8 col-sm-12">';
                echo '<form action="insertion.php" method="post" >';

                echo '<table>';

                echo '<tr>
                        <th>Course Type:</th>
                            <th>
                                <select name="type" required>
                                    <option value="short_course">Short course</option>
                                    <option value="foundational_certificate">Foundational certificate</option>
                                    <option value="certificate">Certificate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="bachelors">Bachelors</option>
                                </select>
                            </th>
                    </tr>';

                echo '<tr>';
                echo '<th>Course code:</th>';
                echo '<th><input type="text" name="code" placeholder="Course code" required></th>';
                echo '</tr>';
                echo '<tr>';
                echo '<th>Course name:</th>';
                echo '<th><input type="text" name="name" placeholder="Course name" required></th>';
                echo '</tr>';
                echo '<tr>';

                $stmt = $conn->prepare('SELECT * FROM faculty');
                $stmt->execute();


                echo '<th><label for="fac">Faculty</label></th>
                    <th><select name="fac" id="fac" required>
                    <option value="">Choose faculty</option>
                ';

                while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                echo '<option value='.$row['id'].'>'.$row['code'].'</option>';
                }
                echo '</select></th>';
                echo '</tr>';

                echo '<tr>
                <th>Duration(values):</th>
                <th>
                    <input type="number" name="durationValue" placeholder="eg 4" required>
                </th>
                <tr>
                </tr>
                <th>Duration(units):</th>
                <th>
                    <select name="durationUnits" required>
                        <option value="y">Years</option>
                        <option value="m">Months</option>
                        <option value="w">Weeks</option>
                    </select>
                </th>
                </tr>';

                echo '<tr>';
                echo '<th><input type="submit" name="add_course" value="Submit"></th>';
                echo '</tr>';
                echo '</table>';
                echo '</form></div>';

                $conn = null;
            }else if($_GET['add'] == "module"){

                echo '<div class="col-8 col-sm-12">';
                echo '<form action="insertion.php" method="post">';

                echo '<table>';
                echo '<tr>';
                echo '<th>Module code:</th>';
                echo '<th><input type="text" name="code" placeholder="Module code" required></th>';
                echo '</tr>';
                echo '<tr>';
                echo '<th>Module name:</th>';         
                echo '<th><input type="text" name="name" placeholder="Module name" required></th>'; 
                echo '</tr>';
              
                echo '<tr>';
                echo '<th><label for="sem">Semester</label></th>
                <th><select name="sem" id="sem" required>
                <option value="">Choose semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                </select></th>';
                echo '</tr>';


                echo '<tr>';
                echo '<th><label for="yr">Year</label></th>
                <th><select name="yr" id="yr" required>
                <option value="">Choose year</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                </select></th>';
                echo '</tr>';

                echo '<tr>';
                echo '<th><label for="course">Courses that do this module</label></th>';
                $stlt = $conn->prepare('SELECT `id`, `name` FROM `course`');
                $stlt->execute();
                echo '<th>';
                while($row = $stlt->fetch(PDO::FETCH_ASSOC) ){
                    echo '<input type="checkbox" name="course[]" id="course" value='.$row['id'].'>'.str_replace( '_', ' ', $row['name']).'<br>';
                }
                echo '</th>';
                echo '</tr>';
                echo '<tr>';
                echo '<th><input type="submit" name="add_module" value="Submit"></th>';
                echo '</tr>';
                echo '</table>';

                echo '</form></div>';

                $conn = null;
            }
        }
if($_SESSION['dept'] == "finance"){
    ?>
<div class="col-12 col-sm-12 view">
        <table style="text-align: left;" align="center" style="background-color: black;">
            <h2 align="center">SET TUITION FOR COURSES<br><hr>
             <!--   <input type="radio" name="currency" value="USHS" required>Uganda shillings  
                <input type="radio" name="currency" value="USD" required>US dollar</h2><hr>-->
            <tr>
                <th>COURSE NAME</th>
                <th>DURATION</th>
                <th>TYPE</th>
                <th>STUDENTS</th>
                <th>TUITION</th>
            </tr>

            <?php
            $stmt = $conn->prepare('SELECT id FROM course');
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC) ){
                ?>
<form action="updation.php" method="post">
    
<?php
                $course = new Course($row['id']);
            echo "
            <tr>
                <td> {$course->name} </td>
                <td> {$course->duration} </td>
                <td> {$course->type} </td>
                <td> {$course->numberOfStudents} </td>
                <td> <input type='text' name='tuition' id='tuition' value='{$course->tuition}'> </td>
                <input type='hidden' name='id' value='{$row['id']}'>
                <td><input type='submit' value='SET TUITION' name='tuition_sub'></td>
            </tr>";
            echo "</form>";

            }
        ?>

        </table>
<?php } ?>
</div>
</main>
<footer class="row">
	    <?php include "footer.php"?>
</footer> 
</body>
</html>