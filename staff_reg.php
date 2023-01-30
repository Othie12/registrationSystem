<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff registration</title>
    <link rel="stylesheet" href="registration.css">

</head>
<body>

<?php include "header.php"?>

<main class="row">

<div class="col-3 col-sm-12"></div>

    <div class="col-6 col-sm-12">
<form action="insertion.php" method="post" align="center">
        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>

    <h3>STAFF REGISTRATION</h3><hr>

    <?php 
        if (isset($_GET['error'])) {
            echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
        }
    ?>
<table style="text-align: left;" align="center">
            <tr>
                <th>Surname:</th>
                <th><input type="text" name="sname" placeholder="eg Oketcho" required></th>
            </tr>
            <tr>
                <th>Middle name:</th>
                <th><input type="text" name="mname" placeholder="eg Ahumuza"></th>
            </tr>
            <tr>
                <th>Last name:</th>
                <th><input type="text" name="lname" placeholder="eg Edrian" required></th>
            </tr>
            <tr>
                <th>Username:</th>
                <th><input type="text" name="uname" placeholder="eg Geohot44" required></th>
            </tr>
            <tr>
                <th>Email:</th>
                <th><input type="email" name="email" id="email" placeholder="eg georgemakubuya@gmail.com" required></th>
            </tr>
            <tr>
                <th>Contact:</th>
                <th><input type="tel" name="tel" id="tel" placeholder="eg +256702838368" required></th>
            </tr>
            <tr>
                <th><label for="sex">Gender: </label></th>
                <th><input type="radio" name="sex" value="M" required>Male  
                    <input type="radio" name="sex" value="F" required>Female</th>
            </tr>
            <tr>
                <th><label for="dept">Department:</label></th>
                <th>
                    <select name="dept" id="dept" required>
                        <option value="">Choose department</option>
                        <option value="registry">Registry</option>
                        <option value="finance">Finance</option>
                    </select>
                </th>
            </tr>
            <tr>
                <th><label for="pwd">PASSWORD(4 to 6 characters):</label></th>
                <th><input type="password" name="pwd" id="pwd" placeholder="Any password they won't forget" minlength="4" maxlength="6" required></th>
            </tr>
            <tr>
                <th><label for="pwdr">REPEAT PASSWORD:</label></th>
                <th><input type="password" name="pwdr" id="pwdr" placeholder="Repeat that password again" minlength="4" maxlength="6" required></th>
            </tr>
            <tr>
                <th><input type="submit" value="Submit" name="staff_sub"></th>
            </tr>
        </table>
    </form>
    </div>
    <div class="col-3 col-sm-12"></div>

</main>

    <footer class="row">
	    <?php include "footer.php"?>
    </footer> 

</body>
</html>