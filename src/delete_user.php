<?php
/*
Use this endpoint to test the request
http://localhost/main-store/src/delete_user.php?userID=ANY-ID-NUMBER
*/
include("../settings/database.php");

$userID = $_GET['userID'];
$sql_delete_user = "DELETE FROM users WHERE id='$userID'";
$res = pg_query($local_conn, $sql_delete_user);
if (!$res) {
    echo "<script>alert(' User hasn't been deleted successfully...');</script>";
    header('refresh:0;url=list_users.php');
} else {
    echo"<script>alert('User has been deleted successfully');</script>";
    header('refresh:0;url=list_users.php');
}