<?php
require('../settings/database.php');

// Recibir datos del formulario
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$ident_number = isset($_POST['ident_number']) ? $_POST['ident_number'] : '';
$mobile_phone = isset($_POST['mobile_phone']) ? $_POST['mobile_phone'] : '';
$email = $_POST['email'];
$password = password_hash($_POST['pswd'], PASSWORD_DEFAULT);
$PHOTO_URL = 'photos/photo-defautl.png';

// Verificar si el correo ya existe
$sql_check_email = "SELECT * FROM users WHERE email='$email'";
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);

if ($total < 1) {
    // Insertar el nuevo usuario
    $sql = "INSERT INTO users (firstname, lastname, ident_number, email, password, url_photo, mobile_phone)
    VALUES ($1, $2, $3, $4, $5, $6, $7)";

    $res = pg_query_params($local_conn, $sql, array(
        $first_name,
        $last_name,
        $ident_number,
        $email,
        $password,
        $PHOTO_URL,
        $mobile_phone
    ));

    if ($res) {
        echo "<script>alert('user has been created successfully!!!')</script>";
        header('refresh:0;url=signin.html');
    } else {
        echo "Error. User hasn't been created successfully";
    }
} else {
    echo "<script>alert('user email already exist. Try again !!!')</script>";
    header('refresh:0;url=signup.htm');
}
?>