<?php

session_start();
session_unset();
session_destroy();
header('Location: /todo_app/auth/login.php');
exit;