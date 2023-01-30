<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registration login</title>
	<link rel="stylesheet" href="registration.css">
</head>
<?php include "header.php"?>
<body>
<main class="row">
    <div class="col-3 col-sm-12"></div>
<?php if($_GET['form'] == 'student'){ ?>
    <!--student login form-->
    <div class="col-6 col-sm-12">
	<form action="loger.php" method="post" align="center">
        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>
        <h2 align="center">STUDENT LOGIN</h2><hr>
        <?php 
                if (isset($_GET['stderror'])) {
                    echo "<h3 align='center' class='errormsg'>{$_GET['stderror']}</h3>";
                }
            ?>
        <table>
            <tr>
                <th>Student number:</th>
                <th><input type="text" name="id_no" placeholder="LUCT110004"></th>
            </tr>
            <tr>
                <th>Password:</th>
                <th><input type="password" name="pwd" placeholder="Your registration password"></th>
            </tr>
        </table>
        <input type="submit" name="studentLogin" value="Login" align="center">
    </form>
    </div>

    <!--staff login form-->
<?php }elseif($_GET['form'] == 'staff'){ ?>
    <div class="col-6 col-sm-12">
	<form action="loger.php" method="post" align="center">
        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>
        <h2 align="center">STAFF LOGIN</h2><hr>
            <?php 
                if (isset($_GET['stafferror'])) {
                    echo "<h3 align='center' class='errormsg'>{$_GET['stafferror']}</h3>";
                }
            ?>
        <table>
            <tr>
                <th>Username:</th>
                <th><input type="text" name="uname" placeholder="eg Othie4454"></th>
            </tr>
            <tr>
                <th>Password:</th>
                <th><input type="password" name="pwd" placeholder="Your registration password"></th>
            </tr>
        </table>
        <input type="submit" name="staffLogin" value="Login" align="center">
    </form>
    </div>

<?php }elseif($_GET['form'] == 'applicant'){ ?>
    <!--applicant login form-->
    <div class="col-6 col-sm-12">
	<form action="loger.php" method="post" align="center">
        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>
        <h2 align="center">APPLICANT LOGIN</h2><hr>
            <?php 
                if (isset($_GET['applerror'])) {
                    echo "<h3 align='center' class='errormsg'>{$_GET['applerror']}</h3>";
                }
            ?>
        <table>
            <tr>
                <th>Surname:</th>
                <th><input type="text" name="sname" placeholder="eg Mukasa"></th>
            </tr>
            <tr>
                <th>Last name:</th>
                <th><input type="text" name="lname" placeholder="eg John"></th>
            </tr>
            <tr>
                <th>Password:</th>
                <th><input type="password" name="pwd" placeholder="Your application password"></th>
            </tr>
        </table>
        <input type="submit" name="applicantLogin" value="Login" align="center">
    </form>
    </div>
<?php } ?>
<div class="col-3 col-sm-12"></div>
</main>
<footer class="row">
	<?php include "footer.php"?>
</footer>

</body>
</html>