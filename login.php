<?php require_once("includes/sessions.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php require_once("includes/functions.php"); ?>

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
                <a href="/MyResume/login.php">
                    Login
                </a>
                <a href="/MyResume/signup.php">
                    Signup
                </a>
            </div>
        </div>

    </nav>

    <!-- login form -->


    <?php
        if(isset($_POST["login"])){
            $email=($_POST["email"]);
            $password=($_POST["password"]);
            require_once("includes/db.php");
            $con;
            if ($con) {
                $stmt = $con->prepare("SELECT user_id, name, password FROM users WHERE email = ?");
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($userid, $name, $db_pwd);
                while ($stmt->fetch()) {
                    $user_pw = $db_pwd;
                    $user_name=$name;
                    $user_id = $userid;
                }
                $numRows = $stmt->num_rows;
                if ($numRows === 0) {
                    echo "email not found";
                }
                else {
                    if (!password_verify($password, $user_pw)){
                        echo "invalid password";
                    }
                    else{
                        echo "correct pw";
                        $_SESSION['user_id']=$user_id;
                        $_SESSION['user_name']=$user_name;
                        header("Location:user.php");
                    }
                }
            }
            else{
                echo "server problem";
            }
        }
    ?>

    <div class="container signup-container">
        <div class="row">
            <div class="offset-sm-3 col-sm-6">

                <form action="login.php" method="post">

                    <h1>Login</h1>
                    <hr>
                    
                    <input type="email" placeholder="Enter Email" name="email" required>
                
                    <input type="password" placeholder="Enter Password" name="password" id="pass" required>
              
                    <div>
                        <u class="custom-switch btn" style="float: right;">
                            <input type="checkbox" class="custom-control-input" onclick="showPassword()" id="customSwitches" >
                            <label class="custom-control-label" for="customSwitches">Show Password</label>
                        </u>
                    </div>

                    <div>
                        <br>
                        <button type="submit" name="login" class="signupbtn">Login</button>
                    </div>

                    <a href="login.php"> Dont have an account? Signup </a>

                </form>

            </div>
        </div>
    </div>

    <script>
        function showPassword() {
            var x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
      </script>

<?php require_once("includes/footer.php"); ?>