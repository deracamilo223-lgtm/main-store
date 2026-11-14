<?php
include"../settings/database.php";
// Get payload from frontend
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$ident_number = $_POST['idnumber'];
$mobile_phone = $_POST['mphone'];
$email = $_POST['email'];
$password = MD5($_POST['pswd']);

$sql_check_email = "SELECT * FROM users WHERE email='$email'";
$res= pg_query($local_conn, $sql_check_email);
$total=pg_num_rows($res);
if($total<1){
// Prepare query
$sql = "INSERT INTO 
users (firstname, lastname, ident_number, mobile_phone, email, password)
VALUES (
'$firstname',
'$lastname',
'$ident_number',
'$mobile_phone',
'$email',
'$password'
)";

// Execute query
$res = pg_query($local_conn, $sql);

if ($res) {
   // echo "<script>alert('User has been created successfully');</script>";
    echo "<script>alert('User has been created successfully');</script>";
    header('refresh:2;url=/main-store/src/signin.html');
} else {
    echo "Error:user hasn't been created successfully...";
}
}else{
    echo "<script>alert('User email already exists');</script>";
    header('refresh:2;url=/main-store/src/signup.html');
    }
?>