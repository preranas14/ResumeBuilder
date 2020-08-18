<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/functions.php"); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand" href="index.php">
            <img src="public/images/logo.jpg" width="50px" height="40px">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
        aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-text">
                <a href="/MyResume/login.php">
                    Login
                </a>
                <a href="/MyResume/signup.php">
                    Signup
                </a>
            </div>
        </div>

    </nav>

    <div class="container">
        <div class="row">
            <h2 style="margin-top: 15px;">
                Current Resume Profiles :-
            </h2>
        </div>

            <?php
                require_once("includes/db.php");
                $con;
                if ($con) {
                    $stmt = $con->prepare("
                    SELECT name, user_id FROM users");
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($name, $id);
                    $i=1;
                    while ($stmt->fetch()) {
                        echo "
                        <div class='row'>
                            <a href='resume.php?id={$id}'>
                                {$i} .&nbsp; {$name}
                            </a>
                        </div>
                        ";
                        $i=$i+1;
                    }
                }
            ?>
    </div>


<?php require_once("includes/footer.php"); ?>