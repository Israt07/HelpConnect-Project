<?php

include('../../database/connect.php');

session_start();
session_unset();
session_destroy();

header('Location: /Project/');
exit();

?>