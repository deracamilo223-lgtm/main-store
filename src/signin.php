<?php
include "../settings/database.php";
session_start();

$email = $_POST['email'];
$passwd_form = $_POST['pswd'];  // ✅ Corregido

// ✅ Usando parámetros para seguridad
$sql_check_email = "SELECT id, firstname, lastname, role, password FROM users WHERE email = $1";
$res = pg_query_params($local_conn, $sql_check_email, array($email));

$total = pg_num_rows($res);
$passwd_ok = false;
$row = null; // ✅ Definir la variable antes

if ($total > 0) {
    $row = pg_fetch_assoc($res);
    $passwd_ok = password_verify($passwd_form, $row['password']);
}

if ($total == 1 && $passwd_ok) {
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['User_firstname'] = $row['firstname'];
    $_SESSION['User_lastname'] = $row['lastname'];
    $_SESSION['User_email'] = $row['email'];
    $_SESSION['role'] = $row['role'];
    
    header('refresh:0;url=home.php');
    exit();
} else {
    echo "<script>alert('Invalid email or password');</script>";
    header('refresh:0;url=signin.html');
    exit();
}
?>