<?php
include "../settings/database.php";
session_start();
if(isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
}else{
    header('refresh:0;url=home.php');
}
$email = $_POST['email'];
$password = MD5($_POST['pswd']);

$sql_check_email = "
SELECT 
    id,
    firstname,
    lastname,
    email,
    url_photo
FROM
 users
  WHERE 
   email='$email' and 
   password='$password'";
$res = pg_query($local_conn, $sql_check_email);
$total = pg_num_rows($res);
$row = pg_fetch_assoc($res);

if($total>0){
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['User_firstname'] = $row['firstname'];
    $_SESSION['User_lastname'] = $row['lastname'];
$_SESSION['User_email'] = $row['email'];

    header('refresh:0;url=home.php');
}else{ echo "<script>alert('Invalid email or password');</script>";
    header('refresh:0;url=signin.html');
    }