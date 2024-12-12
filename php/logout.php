<?php
session_start();

include('../include/connection.php');
session_reset();
session_destroy();
header('location: ../intrface/homeClient.php');
?>
