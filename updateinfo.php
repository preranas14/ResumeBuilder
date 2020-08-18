<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/functions.php"); ?>

<php confirm_login() ?>

    <!-- nav -->

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
                <a href="/MyResume/logout.php">
                    Logout
                </a>
            </div>
        </div>

    </nav>

    <?php
        if(isset($_POST["update"])){
            $name=($_POST["name"]);
            $aboutme=($_POST["aboutme"]);
            $skills=($_POST["skills"]);
            $location=($_POST["location"]);

            if(!$aboutme) {
                $aboutme = "notgiven";
            }
            if(!$skills) {
                $skills = "notgiven";
            }
            if(!$location) {
                $location = "notgiven";
            }
            
            require_once("includes/db.php");
            $con;
            if ($con) {
           
                $user_id = $_SESSION['user_id'];
                $stmt = $con->prepare("UPDATE users SET name = ?,  aboutme = ? , skills = ? , location = ?
                WHERE user_id = ? ");
                $stmt->bind_param('sssss', $name, $aboutme, $skills, $location, $user_id);
                $stmt->execute();
                if ($stmt->affected_rows === -1) {
                    echo "Error";
                } else {
                    $stmt->close();
                    echo "Resume updated";
                    Header("Location: user.php");
                }

            }
            else {
                echo "Connection error";
            }
        }

    ?>


    <div class="container signup-container">
        <div class="row">
            <div class="offset-sm-3 col-sm-6">

                <form action="updateinfo.php" method="post">

                    <h1>Update Resume</h1>
                    <hr>
                    
                    <input type="text" placeholder="Enter Name" name="name" required>

                    <input type="text" placeholder="About Me" name="aboutme">

                    <input type="text" placeholder="Enter skills seperated by a ','" name="skills">

                    <input type="text" placeholder="Enter Location" name="location">

                    <div>
                        <button type="submit" name="update" class="updatebtn">Update</button>
                    </div>


                </form>

            </div>
        </div>
    </div>


<?php require_once("includes/footer.php"); ?>