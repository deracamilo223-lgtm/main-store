<?php
/*
Use this URL to print data in browser: 
http://localhost/main-store/src/list_users.php
*/
include "../settings/database.php";
// Get data from users table
$sql="SELECT 
     id,
     firstname || '' || lastname as fullname,
     email,
     mobile_phone,    
     case when status= true then 'Active' else 'Inactive' end as status,
     url_photo
     from 

     users";
     $res=pg_query($local_conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main Store-List Users</title>
        </head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <body>
        <table class="table table-hover" data-bs-theme="dark">

            <tr>
                <th>photo</th>
                <th>FullName</th>
                <th>Email</th>
                <th>Mobile Phone</th>
                <th>Status</th>
                <th>Options </th>
            </tr>
            <?php while($row=pg_fetch_assoc($res)){ ?>
            <tr>
                <!-- Herere print data from database -->
                 <td>
                 <img src="<?php echo $row['url_photo']; ?>" width="40" alt="User photo profile">
                 </td>
                    <td><?php echo $row['fullname']; ?></td>
                
                 <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['mobile_phone']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td align="center">
                    <a href="#">

                        <img src="icons/edit.png" width="20" alt="Edit user">
                       </a> |
                    <a href="#">
                        <img src="icons/search.png" width="20" alt="Search user">
                    </a> |
                    <a href="#">
                        <img src="icons/delete.png" width="20" alt="Delete user">
                    </a>
                    </td>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>