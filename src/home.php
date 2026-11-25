<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
    exit();
}
include "../settings/database.php";

$id = $_SESSION['user_id'];
$sql = "SELECT firstname, lastname FROM users WHERE id = $1";
$res = pg_query_params($local_conn, $sql, array($id));
$User = pg_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Store - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body class="container py-5">
    <div class="card p-5 text-center">
        <h1 class="text-primary fw-bold mb-3">Welcome to Main Store</h1>
        <h3 class="mb-4">
            Hello, 
            <?php 
                if($User){
                    echo $User['firstname'] . ' ' . $User['lastname'];
                } else {
                    echo 'Usuario';
                }
            ?>
            !
        </h3>
        <h5 class="text-secondary mb-3">Menu</h5>
        <a href="list_users.php" class="btn btn-primary btn-lg mb-3">List Users</a>
        <br>
        <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
    </div>
</body>
</html>
