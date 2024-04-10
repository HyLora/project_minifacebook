<?php
session_start();
if (!isset($_SESSION["tipo"])) {
    $risultato = array("status" => "ko", "msg" => "");
    $risultato["status"] = "ko";
    $risultato["msg"] = "Devi prima eseguire l'accesso!";
    header("location:../index.php?status=ko&msg=". urlencode($risultato["msg"]));
    return $risultato;
} else if ($_SESSION["tipo"] == "amministratore") {
    $nome = "add_friend_admin";
} else {
    $nome = "add_friend";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php 
require "../common/header.php";
?>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <?php require "../common/navbar.php"; ?>
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                    <div class="text-center mb-7">
                        <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i
                                class="bi bi-person-circle"></i></div>
                        <h1 class="fw-bolder">Find new friends!</h1>
                        <p class="lead fw-normal text-muted mb-0">Search here the email!</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-5">
                            <form method="GET" action="../backend/add_friend-exe.php">
                                <div class="form-group">
                                    <label>Nuovo Amico</label>
                                    <div class="form mb-3"><input class="form-control" type="text" name="nuovo_amico" placeholder="email_amico"/>
                                    </div>
                                </div>
                                <!-- Submit Button-->
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="submit" type="submit">Request</button></div>
                                <p>    </p>
                                <div class="d-grid"><button class="btn btn-primary btn-lg" id="reset" type="reset">Reset</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer-->
    <?php require "../common/footer.php"; ?>
</body>

</html>
