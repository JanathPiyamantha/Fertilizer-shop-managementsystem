<?php
    session_start();

    // unset
    session_unset();

    // destroy
    session_destroy();

    header('location: ../index.php');
?>
