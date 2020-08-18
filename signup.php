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

    <!-- signup form -->


    <?php
        if(isset($_POST["signup"])){
            $name=($_POST["name"]);
            $email=($_POST["email"]);
            $password=($_POST["password"]);
            require_once("includes/db.php");
            $con;
            if ($con) {
                $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->num_rows;
                if ($numRows > 0) {
                    echo "Email already used.";
                }
                else{
                    $hashedpwd = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $con->prepare("INSERT INTO users(name, email, password)
                    VALUES (?,?,?)");
                    $stmt->bind_param('sss', $name, $email, $hashedpwd);
                    $stmt->execute();
                    if ($stmt->affected_rows === -1) {
                        echo "Error";
                        exit();
                    } else {
                        $stmt->close();
                        echo "User signedup";
                        echo "<script> window.location.replace='client_signup.php'; </script>";
                    }
                }
            }
        }

    ?>


    <div class="container signup-container">
        <div class="row">
            <div class="offset-sm-3 col-sm-6">

                <form action="signup.php" method="post">

                    <h1>Sign Up</h1>
                    <hr>
                    
                    <input type="text" placeholder="Enter Name" name="name" required>
                    
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
                        <button type="submit" name="signup" class="signupbtn">Sign Up</button>
                    </div>

                    <a href="login.php"> Already Have account? Login </a>

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