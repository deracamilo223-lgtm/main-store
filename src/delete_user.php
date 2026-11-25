
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('refresh:0;url=signin.html');
    exit();
}

include "../settings/database.php";

if(isset($_GET['id'])) {
    $userID = $_GET['id'];
    
    // No permitir eliminarse a sí mismo
    if($userID == $_SESSION['user_id']) {
        echo "<script>
            alert('❌ No puedes eliminarte a ti mismo');
            window.location='list_users.php';
        </script>";
        exit();
    }
    
    $sql_delete_user = "DELETE FROM users WHERE id = $1";
    $res = pg_query_params($local_conn, $sql_delete_user, array($userID));
    
    if ($res) {
        echo "<script>
            alert('✅ El usuario fue eliminado correctamente.');
            window.location='list_users.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ El usuario NO pudo ser eliminado. Inténtalo nuevamente.');
            window.location='list_users.php';
        </script>";
    }
} else {
    header('Location: list_users.php');
}
?>

