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

    <div class="container resume-container">

        <?php
            require_once("includes/db.php");
            $con;
            if ($con) {
                $stmt = $con->prepare("
                SELECT name, email, skills, aboutme, location FROM users WHERE user_id = ?");
                $stmt->bind_param('s', $_GET['id']);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($name, $email, $skills, $aboutme, $location);

                while ($stmt->fetch()) {

                    if($skills == "notgiven"){
                        $skills = "<span class='text-muted'>Not given</span>";
                        $skill_array = null;
                    }
                    else {
                        $skill_array = explode(',', $skills);
                        $skills = null;
                    }
                    if($aboutme == "notgiven" || !$aboutme){
                        $aboutme = "<span class='text-muted'>Not given</span>";
                    }
                    if($location == "notgiven" || !$location){
                        $location = "<span class='text-muted'>Not given</span>";
                    }

                    echo "
                        <div class='row resume-header'>
                            <img src='https://source.unsplash.com/random/560x560/?coding languages' alt=' ' width='300px' height='200px'>
                            <div class='resume-name'>
                                <h2 style='margin-top: 15px;'>
                                    {$name}
                                </h2>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-4'>
                                <div class='aboutme'>
                                    About <span> Me </span>
                                    <p>{$aboutme}</p>
                                </div>
                            </div>
                            <div class='offset-1 col-sm-6'>
                                <div class='email'>
                                    Email: 
                                    <span>{$email}</span>
                                </div>
                                <div class='skills'>
                                    Skills: 
                                    <span>{$skills}</span>
                                </div>
                   
                    ";  
                                if($skill_array) {
                                    for ($i=0; $i<count($skill_array); $i++) {
                                        echo "<span class='skill'>$skill_array[$i]</span>";
                                    }
                                }
                    echo"       
                                <div class='location'>
                                    Location:  
                                    <span>{$location}</span>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
        ?>
       
    </div>

<?php require_once("includes/footer.php"); ?>