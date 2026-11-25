<?php
session_start();
require"auth.php";
requireAdmin();

if (!isset($_SESSION['user_id'])) {
    header('Location: signin.html');
    exit();
}

include('../settings/database.php');

// Get user ID from URL
$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    header('Location: list_users.php');
    exit();
}

// Get user information
$sql = 'SELECT * FROM users WHERE id = $1';
$result = pg_query_params($local_conn, $sql, array($id));

$user = pg_fetch_assoc($result);

if (!$user) {
    header('Location: list_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F1F5F9;
            color: #334155;
            margin: 0;
            padding: 40px;
        }

        h1 {
            color: #334155;
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            background-color: #FFFFFF;
            padding: 30px;
            width: 450px;
            margin: 0 auto;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
        }

        label {
            color: #475569;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 92%;
            padding: 10px;
            margin-top: 8px;
            margin-left: 7px;
            border: 1px solid #CBD5E1;
            border-radius: 3px;
            background-color: #F8FAFC;
            color: #334155;
        }

        input[type="file"] {
            margin-top: 10px;
            color: #475569;
        }

        p {
            color: #475569;
            font-weight: bold;
        }

        img {
            border-radius: 8px;
            border: 2px solid #E2E8F0;
        }

        button {
            background-color: #3B82F6;
            color: white;
            padding: 11px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2563EB;
        }

        a {
            background-color: #E2E8F0;
            color: #475569;
            padding: 11px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 8px;
        }

        a:hover {
            background-color: #CBD5E1;
        }
    </style>
</head>
<body>
    <h1>Editar usuario</h1>

    <form action="update_user.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <label>Nombre</label><br>
        <input type="text" name="firstname" value="<?php echo $user['firstname']; ?>" required><br><br>

        <label>Apellido</label><br>
        <input type="text" name="lastname" value="<?php echo $user['lastname']; ?>" required><br><br>

        <label>Correo</label><br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <label>Celular</label><br>
        <input type="text" name="mobile_phone" value="<?php echo $user['mobile_phone']; ?>" required><br><br>

        <?php if ($user['url_photo'] != "") { ?>
            <p>Foto actual:</p>
            <img src="<?php echo $user['url_photo']; ?>" width="120"><br><br>
        <?php } ?>

        <label>Foto (JPG o PNG)</label><br>
        <input type="file" name="photo" accept=".jpg,.jpeg,.png"><br><br>

        <button type="submit">Guardar</button>
        <a href="list_users.php">Cancelar</a>
    </form>
</body>
</html>
