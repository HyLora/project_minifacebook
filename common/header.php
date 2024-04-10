<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Minifacebook"/>
        <meta name="author" content="Chiara e Laura"/>
        <title>Minifacebook</title>
        <!-- Favicon-->
        <?php
        if ($nome == "index") {
                echo '<link rel="icon" type="image/x-icon" href="assets/balloon-heart.svg" />';        
        } else {
                echo '<link rel="icon" type="image/x-icon" href="../assets/balloon-heart.svg" />';
        }?>
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <?php
        if ($nome == "index") {
                echo "<link href='css/styles.css' rel='stylesheet'/>";
                echo "<link href='css/style_personal.css' rel='stylesheet'/>";
                echo "<script src='js/myScript.js'></script>";
        } else {
                echo "<link href='../css/styles.css' rel='stylesheet'/>";
                echo "<link href='../css/style_personal.css' rel='stylesheet'/>";
                echo "<script src='../js/myScript.js'></script>";
        }
        ?>
</head>