<?php
 include "dbconn.php";
 include "functions.php";
 include "classes.php";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="registration.css">

</head>

<?php include "header.php"?>
<body>
<main class="row">

<div class="col-3 col-sm-12"></div>

<div class="col-6 col-sm-12">

    <?php
    $pwd = $_POST['pwd'];
    $pwdr = $_POST['pwdr'];

    if($pwd != $pwdr){
        header("Location: admission.php?error=Your passwords don't match, please recheck them");
     }else{
    ?>

    <form action="insertion.php" method="post" enctype="multipart/form-data" align="center">

        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>

        <h3 align="center">PART TWO</h3><hr>

        <table align="center">
            <tr>
                <th><label for="photo">Passport photo</label></th>
                <th><input type="file" name="photo" id="photo"></th>
            </tr>
            <tr>
                <th><label for="id">Upload Natinal ID picture or passport</label></th>
                <th><input type="file" name="id"></th>
            </tr>
            <tr>
                <th><label for="ple">Upload Photo for PLE result slip</label></th>
                <th><input type="file" name="ple" id="ple"></th>
            </tr>
            <tr>
                <th><label for="uce">Upload Photo for UCE result slip</label></th>
                <th><input type="file" name="uce" id="uce"></th>
            </tr>
            <tr>
                <th><label for="uace">Upload Photo for UACE result slip</label></th>
                <th><input type="file" name="uace" id="uace"></th>
            </tr>

            <?php
                if(isset($_POST['cid'])){//user has got here via course.php
                    echo '<input type="hidden" name="course" value="'.$_POST['cid'].'">';
                }else{
            ?>

            <tr>
                <th><label for="course">Desired course</label></th>
                <th><select name="course" id="course" required>
                <option value="">Choose Course</option>

<?php
                $stlt = $conn->prepare('SELECT `id`, `name` FROM `course`');
                $stlt->execute();
                while($row = $stlt->fetch(PDO::FETCH_ASSOC) ){
                
?>
                        <option value="<?php echo $row['id'] ?>"><?php echo str_replace( '_', ' ', $row['name']) ?></option>
        <?php } ?>
                    </select>
                </th>
            </tr>
            <?php } ?>
            <tr>
                <th><label for="intake">Intake</label></th>
                <th><select name="intake" id="intake">
                        <option value="">Choose Intake</option>
                        <option value="feb">February</option>
                        <option value="july">July</option>
                        <option value="aug">August</option>
                    </select>
                </th>
            </tr>
            <tr>
                <th><label for="bankslip">Upload bankslip to verify your admission fee payment</label></th>
                <th><input type="file" name="bankslip"></th>
            </tr>
        <input type="hidden" name="sname" value="<?php echo $_POST['sname'] ?>" >
        <input type="hidden" name="mname" value="<?php echo $_POST['mname'] ?>" >
        <input type="hidden" name="lname" value="<?php echo $_POST['lname'] ?>" >
        <input type="hidden" name="email" value="<?php echo $_POST['email'] ?>" >
        <input type="hidden" name="tel" value="<?php echo $_POST['tel'] ?>" >
        <input type="hidden" name="sex" value="<?php echo $_POST['sex'] ?>" >
        <input type="hidden" name="nin" value="<?php echo $_POST['nin'] ?>" >
        <input type="hidden" name="dob" value="<?php echo $_POST['dob'] ?>" >
        <input type="hidden" name="nationality" value="<?php echo $_POST['nationality'] ?>" >
        <input type="hidden" name="pwd" value="<?php echo $_POST['pwd'] ?>" >

        <input type="hidden" name="finance" value="pending">
        <input type="hidden" name="registry" value="pending">
            <tr>
                <th align="right"><input type="submit" value="Submit" name="admission_sub"></th>
            </tr>
        </table>
    </form>
    <?php } ?>
</div>

<div class="col-3 col-sm-12"></div>

</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>