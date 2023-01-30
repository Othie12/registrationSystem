<html lang="en">
    <?php 
    include "classes.php";
    include "dbconn.php";
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

<h1 align="center" style="text-decoration: underline;">EDIT INFORMATION</h1>
    <?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
        ?>
<div class="col-2 col-sm-12"></div>

<div class="col-8 col-sm-12">
    <form action="updation.php" method="post" onsubmit="window.confirm('Are you sure?')" >
        <div align="center">
            <img src="lim logo.jpg" alt="logo" class="limlogo">
        </div>
        
        <hr>

        <table style="text-align: left;" align="center">

        <?php
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];
                $applicant = new Applicant($id);
                if($_SESSION['dept'] == 'applicant'){
                    ?>

            <tr>
                <th>Surname:</th>
                <td><input type="text" name="sname" value="<?php echo $applicant->sname ?>"></td>
            </tr>
            <tr>
                <th>Middle name:</th>
                <td><input type="text" name="mname" id="" value="<?php echo $applicant->mname ?>"></td>
            </tr>
            <tr>
                <th>Last name:</th>
                <td><input type="text" name="lname" id="" value="<?php echo $applicant->lname ?>"></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><input type="text" name="email" id="" value="<?php echo $applicant->email ?>"></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><input type="text" name="tel" id="" value="<?php echo $applicant->tel ?>"></td>
            </tr>
            <tr>
                <th><label for="sex">Gender: </label></th>
                <td><input type="radio" name="sex" value="<?php echo $applicant->sex ?>" checked><?php echo $applicant->sex ?>  
                    ---<input type="radio" name="sex" value="M" >M
                    <input type="radio" name="sex" value="F" >F</td>
            </tr>
            <tr>
                <th><label for="dob"> DOB:</label></th>
                <td><input type="date" name="dob" value="<?php echo $applicant->dob ?>"></td>
            </tr>
            <tr>
                <th><label for="nationality">Nationality</label></th>
                <td><select name="nationality" id="nationality" required>
                    <option value="<?php echo $applicant->nationality ?>"><?php echo $applicant->nationality ?></option>
                    <option value="Ugandan">Ugandan</option>
                    <option value="Kenyan">Kenyan</option>
                    <option value="Tanzanian">Tanzanian</option>
                    <option value="Indian">Indian</option>
                    </select></td>
            </tr>
            <tr>
                <th><label for="nin">NIN/Passport number</label></th>
                <td><input type="text" name="nin" value="<?php echo $applicant->nin ?>"></td>
            </tr>
            <tr>
                <th><label for="course">Desired course</label></th>
                <td>
                    <select name="course" id="course">
                    <option value="<?php echo $applicant->desiredCourseId ?>"><?php echo $applicant->desiredCourse ?></option>

                        <?php
                        $stlt = $conn->prepare('SELECT `id`, `name` FROM `course`');
                        $stlt->execute();
                        while($row = $stlt->fetch(PDO::FETCH_ASSOC) ){              
                        ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo str_replace( '_', ' ', $row['name']) ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="intake">Intake</label></th>
                <td>
                    <select name="intake" id="intake">
                        <option value="<?php echo $applicant->intake ?>"><?php echo $applicant->intake ?></option>
                        <option value="feb">February</option>
                        <option value="july">July</option>
                        <option value="aug">August</option>
                    </select>
                </td>
            </tr>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <tr>
                <td></td>
                <td><input type="submit" value="UPDATE" name="update_sub1"></td>
            </tr>
            
            <?php
                }else{
                    ?>
                    <h3>Since you are already a student, most of your data has been recorded. You are not allowed to change much of it</h3>
                    <?php
                }
            }
        ?>
        
        </table>
      </form>
</div>

    <div class="col-2 col-sm-12"></div>

<div class="row">
    <div class="col-12 col-sm-12">
        <form action="updation.php" method="post" enctype="multipart/form-data" onsubmit="window.confirm('sure?')" >
            <h3 align="center">UPDATE FILE</h3><hr>
            <table>
                <tr>
                    <th><label for="key">CHOOSE FILE TO UPDATE</label></th>
                    <td><select name="key" required>
                            <option value="">__Choose option__</option>
                            <option value="ppt_photo">Passport photo</option>
                            <option value="id_pic">Picture of national ID or passport</option>
                            <option value="ple">Picture for PLE result slip</option>
                            <option value="uce">Picture for UCE result slip</option>
                            <option value="uace">Picture for UACE result slip</option>
                            <option value="bankslip">Bank payment slip(bankSlip)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="val">UPLOAD FILE</label></th>
                    <td><input type="file" name="val"></td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <tr>
                    <td></td>
                    <td><input type="submit" value="UPLOAD" name="update_sub2"></td>
                </tr>
            </table>
            
        </form>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">Passport photo</h2>
            <a href='<?php echo "images/{$applicant->pptPhoto}" ?>'><img src='<?php echo "images/{$applicant->pptPhoto}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">Natinal ID picture or passport</h2>
            <a href='<?php echo "images/{$applicant->idPic}" ?>'><img src='<?php echo "images/{$applicant->idPic}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">Photo for PLE result slip</h2>
            <a href='<?php echo "images/{$applicant->ple}" ?>'><img src='<?php echo "images/{$applicant->ple}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">Photo for UCE result slip</h2>
            <a href='<?php echo "images/{$applicant->uce}" ?>'><img src='<?php echo "images/{$applicant->uce}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">Photo for UACE result slip</h2>
            <a href='<?php echo "images/{$applicant->uace}" ?>'><img src='<?php echo "images/{$applicant->uace}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
    <div class="col-6 col-sm-6">
        <div class="pic">
            <h2 align="center">bankslip to verify admission fee payment</h2>
            <a href='<?php echo "images/{$applicant->bankSlip}" ?>'><img src='<?php echo "images/{$applicant->bankSlip}" ?>' alt="passport photo" width='100%' height='auto'></a>
        </div>
    </div>
</div>
<?php
    
?>
</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>