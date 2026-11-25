<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit();
}

include "../settings/database.php";

$id = $_GET['id'];

$sql_check = "SELECT status FROM users WHERE id = $1";
$res_check = pg_query_params($local_conn, $sql_check, array($id));
$user = pg_fetch_assoc($res_check);

if ($user['status'] == 't') {
    $nuevo_estado = 'f';
    $mensaje = "Usuario desactivado correctamente";
} else {
    $nuevo_estado = 't';
    $mensaje = "Usuario activado correctamente";
}

$sql_update = "UPDATE users SET status = $1 WHERE id = $2";
pg_query_params($local_conn, $sql_update, array($nuevo_estado, $id));

header("Location: list_users.php?msg=$mensaje");
exit();
?>
