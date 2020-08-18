<?php
    require_once("includes/sessions.php");
    $_SESSION["user_id"] = null;
    $_SESSION["user_name"] = null;
    session_destroy();
    Header("Location: index.php");
?>