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

<h1 align="center" style="text-decoration: underline;">APPLICANT INFORMATION</h1>

<div class="col-2 col-sm-12"></div>

    <div class="col-8 col-sm-12">
<div class="view">
        <div align="center">
            <img src="lim logo.jpg" alt="logo" class="limlogo">
        </div>
        
        <hr>

        <table style="text-align: left;" align="center">
        <?php 
            if (isset($_GET['error'])) {
                echo "<h3 align='center' class='errormsg'>{$_GET['error']}</h3>";
            }
        ?>
        <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $applicant = new Applicant($id);
            
        ?>

            <tr>
                <th>Surname:</th>
                <td><?php echo $applicant->sname ?></td>
            </tr>
            <tr>
                <th>Middle name:</th>
                <td><?php echo $applicant->mname ?></td>
            </tr>
            <tr>
                <th>Last name:</th>
                <td><?php echo $applicant->lname ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo $applicant->email ?></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><?php echo $applicant->tel ?></td>
            </tr>
            <tr>
                <th><label for="sex">Gender: </label></th>
                <td><?php echo $applicant->sex ?></td>
            </tr>
            <tr>
                <th><label for="dob"> DOB:</label></th>
                <td><?php echo $applicant->dob ?></td>
            </tr>
            <tr>
                <th><label for="nationality">Nationality</label></th>
                <td><?php echo $applicant->nationality ?></td>
            </tr>
            <tr>
                <th><label for="nin">NIN/Passport number</label></th>
                <td><?php echo $applicant->nin ?></td>
            </tr>
            <tr>
                <th><label for="course">Desired course</label></th>
                <td><?php echo $applicant->desiredCourse ?></td>
            </tr>
            <tr>
                <th><label for="intake">Intake</label></th>
                <td><?php echo $applicant->intake ?></td>
            </tr>
        </table>
      <a href="adforms.php"><button>BACK</button></a>
      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?template=message&id=<?php echo $id ?>"><button>MESSAGE</button></a>
      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?template=reject&id=<?php echo $id ?>"><button>REJECT</button></a>
<?php if($_SESSION['dept'] == "registry"){ ?>
      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?template=admit&id=<?php echo $id ?>"><button>ADMIT</button></a>
<?php }elseif($_SESSION['dept'] == "finance"){ ?>
      <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?template=accepted&id=<?php echo $id ?>"><button>ACCEPTED</button></a>
<?php } ?>
      <?php
        if(isset($_GET['template'])){
      ?>
    <form action="updation.php" method="post">
        <?php if($_GET['template'] == "message"){ ?>
            <textarea name="message" id="" cols="30" rows="10" placeholder="Is anything wrong with the admission form, put the submission here and the applicant will find the message here, and then they'll update their information" maxlength="800"></textarea>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <input type="submit" value="Submit" name="message_sub">

        <?php }elseif($_GET['template'] == "admit"){ ?>
            <table>
                <p>By admiting the applicant you are officially making him a student offering the course they applied for.</p>
                <tr>
                    <th>Student number</th>
                    <th><input type="text" name="stdntNo" placeholder="Give this applicant a new student number"></th>
                </tr>
                <tr>
                    <th>Expected Arrival date</th>
                    <th><input type="date" name="arrival_date" placeholder="When are they expected to start their semester"></th>
                </tr>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <input type="hidden" name="sname" value="<?php echo $applicant->sname ?>">
                <input type="hidden" name="lname" value="<?php echo $applicant->lname ?>">
                <input type="hidden" name="course" value="<?php echo $applicant->desiredCourse ?>">

                <tr>
                <input type="submit" value="Submit" name="admit_sub">
                </tr>
            </table>
        <?php } ?>
    </form>
<?php if($_GET['template'] == "accepted"){

    $sname = $applicant->sname;
    $lname = $applicant->lname;

    $id = $_GET['id'];
    $stmt = $conn->prepare('UPDATE applicant SET finance = :finance WHERE id = :id');
    if($stmt->execute([':finance' => 'a', ':id' => $id])){
        header('Location: adforms.php?error='.$sname.' '.$lname.' will be viewed by the registrar now&id='.$id.'');
    }else{
        header('Location: viewApplicant.php?error=Sorry, we encountered a problem, try re-accepting this applicant&id='.$id.'');
    }
 }
 } ?>

      <?php// } ?>
      </div>
    </div>
    <div class="col-2 col-sm-12"></div>

<div class="row">
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
    }
?>
</main>

    <footer>
	    <?php include "footer.php"?>
    </footer> 
</body>
</html>