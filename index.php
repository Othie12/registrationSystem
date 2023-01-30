<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registration System</title>
	<link rel="stylesheet" href="registration.css">
    <style>
        .starter{
            background-image: url(images/limcampus.jpg);
            background-repeat: no-repeat;
            background-size: 100%;
        }
        .blq{
            background-color: rgba(93, 93, 93, 0.6);
            border-radius: 5vh;
        }
        .blq > h3 {
            color: black;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php include_once "header.php"?>

<main class="row">

<?php
	if(isset($_SESSION['loggedIn']) /*&& $_SESSION['dept'] == "applicant" || $_SESSION['dept'] == "student"*/){
		if(isset($_SESSION['msg'])){
?>
	<div class="col-6 col-sm-12">
            <article class="framer">
                <div class="dh" >
                    <h3 align="center" style="color: red;">Notification</h3>
                </div>
                <div class="cont">
				<p><?php echo str_replace('_', ' ', $_SESSION['msg'])?></p>
                </div>
            </article>
        </div>

<?php
		}
	}
?>

    <div class="col-4 col-sm-12">
        <div class=row>
                <div class="col-12 col-sm-12 blq">
                    <h3 align="center">akjsdkljfaddfajklsdf</h3>
                    <p>jdlhfaj khds jf khajs kdhfjk ashdfjkhalsjd fhlak sdhfla sdjfh akls dhfl
                        ashd kljfh aklsdhfj kalhs dkjfhl asdfhlj kashd fjk
                        fahjskdf asdjf asd fjashdf lasdhf asdhljf askjd f
                    </p>
                </div>

                <div class="col-1 col-sm-12"></div>

                <div class="col-12 col-sm-12 blq">
                <h3 align="center">akjsdkljfaddfajklsdf</h3>
                    <p>jdlhfaj khds jf khajs kdhfjk ashdfjkhalsjd fhlak sdhfla sdjfh akls dhfl
                        ashd kljfh aklsdhfj kalhs dkjfhl asdfhlj kashd fjk
                        fahjskdf asdjf asd fjashdf lasdhf asdhljf askjd f
                    </p>
                </div>
                <div class="col-12 col-sm-12"></div>
            </div>
            <div class="col-12 col-sm-12 blq" >
        <h3 align="center">akjsdkljfaddfajklsdf</h3>
            <p>jdlhfaj khds jf khajs kdhfjk ashdfjkhalsjd fhlak sdhfla sdjfh akls dhfl
                ashd kljfh aklsdhfj kalhs dkjfhl asdfhlj kashd fjk
                fahjskdf asdjf asd fjashdf lasdhf asdhljf askjd f
            </p>
    </div>

        </div>
    </div>
    <div class="col-8 col-sm-12">
        <img src="images/silo.jpeg" alt="silo" width="100%">
    </div>
    
</main>
<footer class="row">
	<?php include_once "footer.php"?>
</footer>

</body>
</html>