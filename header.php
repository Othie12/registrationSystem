<?php
session_start();
function cla($pgname){
	$page = $_SERVER['PHP_SELF'];
	if($page == $pgname){
		echo "class=\"active\"";
	}else{
		echo "";
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
	<link rel="stylesheet" href="registration.css">
	<style>
		
		button ul {
			display: none;
			position: absolute;
			top: 30px;
		}
		button:hover > ul {
			display: inherit;
		}
		button > ul > li {
			width: 170px;
			float: none;
			display: list-item;
			position: relative;
		}
		button > ul > li a:hover {
			background-color: #333;
		}
		button::after {content: '+';}
		button:not(.pie)::after{content: '';}
		button:not(.pie):hover::after{content: '-';}

	</style>
</head>

<body style="margin: 0; padding: 0;" >
	<div align="center" style="background-color: #171717; margin: 0; padding: 0;"><img src="Limkokwing logo.png" alt="limkokwing logo"></div>
<div id="header" class="row">
	<div id="headinfo">
		<?php
			if(isset($_SESSION['loggedIn']) && $_SESSION['dept'] == "applicant"){
		?>
		<div class="logo">
		<img src='<?php echo "images/{$_SESSION['dp']}" ?>' alt="dp" class="logo">
		</div>
		<?php }else{ ?>
		<img src="lim logo.jpg" alt="logo" id="limlogo">
		<?php } ?>
	</div>

	<div id="navigation">
		<ul>

		<?php
		//if a person from registry has logged in then show them this dashboard
		if( isset($_SESSION['loggedIn']) && $_SESSION['dept'] == "registry"){
		?>
			<li <?php cla("/registrationSystem/adforms.php"); cla("/registrationSystem/viewApplicant.php")  ?>><a href="adforms.php">Admission Forms</a></li>
			<li <?php cla("/registrationSystem/regForms.php") ?>><a href="regForms.php">Registration Forms</a></li>
			<li <?php cla("/registrationSystem/academia.php")?>><a href="academia.php">Academia</a></li>
		<?php
		//dashboard for staff member who belongs to finance
		}elseif( isset($_SESSION['loggedIn']) && $_SESSION['dept'] == "finance") {
		?>
			<li <?php cla("/registrationSystem/adforms.php")?>><a href="adforms.php">Admission Forms</a></li>
			<li <?php cla("/registrationSystem/regForms.php") ?>><a href="regForms.php">Registration Forms</a></li>
			<li <?php cla("/registrationSystem/academia.php")?>><a href="academia.php">Academia</a></li>

		<?php
		//dashboard for an applicant who has'nt become a student yet
		}elseif(isset($_SESSION['loggedIn']) && $_SESSION['dept'] == "applicant"){
		?>
			<li <?php cla("/registrationSystem/edit.php")?>><a href="edit.php">Edit info</a></li>

		<?php
		//dashboard for a student
		}elseif(isset($_SESSION['loggedIn']) && $_SESSION['dept'] == "student"){
		?>
			<!--<li><a href="#">Edit info</a></li>-->
			<li <?php cla("/registrationSystem/tt.php")?>><a href="tt.php">Timetable</a></li>
			<li <?php cla("/registrationSystem/register.php")?>><a href="register.php">Register</a></li>

		<?php
		}else{
			//dassboard for the home visitor
		?>
		  <li <?php cla("/registrationSystem/index.php")?>><a href="index.php">Home</a></li>
		  <li <?php cla("/registrationSystem/courses.php")?>><a href="courses.php">Courses</a></li>
		  <li <?php cla("/registrationSystem/admission.php")?>><a href="admission.php">Admission</a></li>
		  <?php
		}
		?>
		</ul>
		
	</div>

<?php if (isset( $_SESSION['loggedIn']) && $_SESSION['loggedIn']){ ?>
	<button style="margin-bottom: 1vw; border-raduis: 14%; text-decoration: none;" align="right"><a href="logout.php">Logout</a></button>
<?php }elseif (!isset( $_SESSION['loggedIn'])){ ?>
	<button class="pie" style="margin-bottom: 1vw; border-raduis: 0; text-decoration: none;" align="right">Login</a>
		<ul>
			<li><a href="login.php?form=applicant">Applicant</a></li>
			<li><a href="login.php?form=student">Student</a></li>
			<li><a href="login.php?form=staff">Staff</a></li>
		</ul>
	</button>
<?php } ?>
</div>


</body>
</html>