<?php

    function check_login(){
        if(isset($_SESSION["user_id"])){
            return true;
        }
        else{
            return false;
        }
    }

    function confirm_login(){
        if(!check_login()){
            Header("Location: login.php");
        }
    }

 ?>