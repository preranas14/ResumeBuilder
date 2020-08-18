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

    <div class="container">
        <div class="row">
            <div class="offset-sm-4 col-sm-4" style="margin-top: 20px;">
                <?php
                require_once("includes/db.php");
                $con;
                if ($con) {
                    $stmt = $con->prepare("
                    SELECT name, email, skills, location, aboutme
                    FROM users WHERE user_id = ?");
                    $stmt->bind_param('s', $_SESSION['user_id']);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($name, $email, $skills, $location, $aboutme);
                    while ($stmt->fetch()) {
                        $user_name = $name;
                        $user_email = $email;
                        $user_skills = $skills;
                        $user_location = $location;
                        $user_aboutme = $aboutme;
                    }
                    if($user_skills == "notgiven"){
                        $user_skills = "<span class='text-muted'>Not given</span>";
                        $skill_array = null;
                    }
                    else {
                        $skill_array = explode(',', $user_skills);
                        $user_skills = null;
                    }
                    if($user_location == "notgiven" || !$user_location){
                        $user_location = "<span class='text-muted'>Not given</span>";
                    }
                    if($user_aboutme == "notgiven"){
                        $user_aboutme = "<span class='text-muted'>Not given</span>";
                    }
                    echo
                    "  
                        <h1>Your Profile</h1>
                        <p>Name: {$user_name}</p>
                        <p>Email: {$user_email}</p>
                        <p>Skills: </p>
                    ";  
                        for ($i=0; $i<count($skill_array); $i++) {
                            echo "<span class='skill'>$skill_array[$i]</span>";
                        }
                    echo"
                        <p>$user_skills</p>
                        <p>Location: {$user_location}</p>
                        <p>About Me: {$user_aboutme}</p>
                        <button onclick='window.location.href=`updateinfo.php`'
                        class='btn btn-primary btn-lg'>Update info</button>
                    ";
                }else {
                    echo "Connection error";
                }
                ?>

            </div>
        </div>
    </div>


<?php require_once("includes/footer.php"); ?>