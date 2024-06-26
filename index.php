<?php
session_start();
//$_SESSION["logged"]=true;
$nome = "index";
?>

<!DOCTYPE html>
<html lang="en">
	<?php  require "common/header.php";?>
	<link href="css/styles.css" rel="stylesheet" />
    
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
			<!-- Navigation-->
			<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container px-4">
        <a class="navbar-brand" href="index.php">
            <!-- Icona del cuore del palloncino -->
            <!--<img src="assets/balloon-heart.svg" alt="Balloon Heart Icon" width="140" height="120" class="d-inline-block">-->
            <svg xmlns="http://www.w3.org/2000/svg" width="140" height="160" fill="#f542ce" class="bi bi-balloon-heart" viewBox="0 0 15 15">
                <path fill-rule="evenodd" d="m8 2.42-.717-.737c-1.13-1.161-3.243-.777-4.01.72-.35.685-.451 1.707.236 3.062C4.16 6.753 5.52 8.32 8 10.042c2.479-1.723 3.839-3.29 4.491-4.577.687-1.355.587-2.377.236-3.061-.767-1.498-2.88-1.882-4.01-.721L8 2.42Zm-.49 8.5c-10.78-7.44-3-13.155.359-10.063.045.041.089.084.132.129.043-.045.087-.088.132-.129 3.36-3.092 11.137 2.624.357 10.063l.235.468a.25.25 0 1 1-.448.224l-.008-.017c.008.11.02.202.037.29.054.27.161.488.419 1.003.288.578.235 1.15.076 1.629-.157.469-.422.867-.588 1.115l-.004.007a.25.25 0 1 1-.416-.278c.168-.252.4-.6.533-1.003.133-.396.163-.824-.049-1.246l-.013-.028c-.24-.48-.38-.758-.448-1.102a3.177 3.177 0 0 1-.052-.45l-.04.08a.25.25 0 1 1-.447-.224l.235-.468ZM6.013 2.06c-.649-.18-1.483.083-1.85.798-.131.258-.245.689-.08 1.335.063.244.414.198.487-.043.21-.697.627-1.447 1.359-1.692.217-.073.304-.337.084-.398Z"/>
            </svg>
        <!-- Testo Minifacebook -->
        <span class="fw-bolder text-primary">Minifacebook</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-10 small fw-bolder">
                <!--<li class="nav-item"><a class="nav-link px-4 mb-2" href="index.php"><h4>Home</h4></a></li>-->
                <li class="nav-item"><a class="nav-link px-4" href="frontend/loginmodificato.php"><h4>Login</h4></a></li>
                <li class="nav-item"><a class="nav-link px-4" href="frontend/joinus.php"><h4>Join Us</h4></a></li>
                <!--<li class="nav-item"><a class="nav-link" href="messages.html">Messages</a></li>-->
            </ul>
        </div>
    </div>
</nav>
        <div class="container px-5">
            <div class="col-md-4">
                <?php if (isset($_GET["status"])) {
                    if ($_GET["status"] == "ok") {
                        echo "<div class='alert alert-success'>\n";
                        echo $_GET["msg"];
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-warning'>\n";
                        echo $_GET["msg"];
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
			<!-- Home -->
			<?php  require "common/home.php";?>
		</main>
		<!-- Footer-->
		<?php  require "common/footer.php";?>
	</body>
</html>
