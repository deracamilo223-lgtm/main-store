<?php
// Get database connection
include('../settings/database.php');

// Get payload from forntend
  $firstname=$_POST['fname'];
  $lastname=$_POST['lname'];
  $ident_number=$_POST['idnumber'];
  $mobile_phone=$_POST['mphone'];
  $email=$_POST['email'];
  $password = MD5($_POST['pswd']);
 
 // Prepare query
 $sql="
 INSERT INTO
  users (firstname, lastname, ident_number, email, password)
   VALUES ('$firstname',
    '$lastname', 
    '$ident_number', 
    '$email',
    '$password');
    ";
    //Execute query
    $res = pg_query($local_conn, $sql);
if ($res) {
    echo "User has ben created succesfully ";
} else {
    echo "Error: Users hasn't been created successfully: " . pg_last_error($local_conn);
}