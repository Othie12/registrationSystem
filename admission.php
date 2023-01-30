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

    <div class="col-3 col-sm-12">
        <div class="view">
            <h3 align="center" >ADMISSION DETAILS</h3>
            <p>This is the main admission page for limkokwing University of creative technology and you are required to fill the admission form
                following the required guidelines.<br><i><b>You need to provide the true details in the form to prevent further confusion<b></i>
        </div>
        <div class="view" style="margin-top: 10px;">
            <h4>REQUIREMENTS FOR ADMISSION</h4>
            <ul>
                <li>You will need to provide your full names and your password to enable you to be able to comeback later to refracture.</li>
                <li>Your current email is required because we shall need to send further information to you through it to inform you if you 
                    have been given a place.</li>
                <li>You need to pay <b>USHS 150,000</b> to the University account number <i>57839483787593</i> at any equity bank branch near you.</li>
            </ul>
        </div>
    </div>

    <div class="col-6 col-sm-12">
    <form action="admission_contd.php" method="post" enctype="multipart/form-data" align="center">

        <div>
            <img src="lim logo.jpg" alt="logo" class="limlogo" >
        </div>

        <h3 align="center">PART ONE</h3><hr>

        <?php 
        if (isset($_GET['error'])) {
            echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
        }
    ?>

        <table style="text-align: left;" align="center">
            <tr>
                <th>Surname:</th>
                <th><input type="text" name="sname" placeholder="Surname" required></th>
            </tr>
            <tr>
                <th>Middle name:</th>
                <th><input type="text" name="mname" placeholder="Middle name"></th>
            </tr>
            <tr>
                <th>Last name:</th>
                <th><input type="text" name="lname" placeholder="Last name" required></th>
            </tr>
            <tr>
                <th>Email:</th>
                <th><input type="email" name="email" id="email" placeholder="Email" required></th>
            </tr>
            <tr>
                <th>Contact:</th>
                <th><input type="tel" name="tel" id="tel" placeholder="contact" required></th>
            </tr>
            <tr>
                <th><label for="sex">Gender: </label></th>
                <th><input type="radio" name="sex" value="M" required>Male  
                    <input type="radio" name="sex" value="F" required>Female</th>
            </tr>
            <tr>
                <th><label for="dob"> DOB:</label></th>
                <th><input type="date" name="dob" id="dob" placeholder="Date of birth" required></th>
            </tr>
            <tr>
                <th><label for="nationality">Nationality</label></th>
                <th><select name="nationality" id="nationality" required>
                    <option value="Ugandan">Ugandan</option>
                    <option value="Kenyan">Kenyan</option>
                    <option value="Tanzanian">Tanzanian</option>
                    <option value="Indian">Indian</option>
                    </select>
                </th>
            </tr>
            <tr>
                <th><label for="nin">NIN/Passport number</label></th>
                <th><input type="text" name="nin" placeholder="NIN/Passport number"></th>
            </tr>
            <tr>
                <th><label for="pwd">PASSWORD(4 to 6 characters):</label></th>
                <th><input type="password" name="pwd" id="pwd" placeholder="Any password they won't forget" minlength="4" maxlength="6" required></th>
            </tr>
            <?php
                if(isset($_GET['cid'])){//user has got here via course.php
                    echo '<input type="hidden" name="cid" value="'.$_GET['cid'].'">';
                }
            ?>
            
            <tr>
                <th><label for="pwdr">REPEAT PASSWORD:</label></th>
                <th><input type="password" name="pwdr" id="pwdr" placeholder="Repeat that password again" minlength="4" maxlength="6" required></th>
            </tr>
            <tr>
                <th align="right"><input type="submit" name="admission_next" value="Next"></th>
            </tr>
        </table>

    </form>
    </div>

    <div class="col-3 col-sm-12"></div>

</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>