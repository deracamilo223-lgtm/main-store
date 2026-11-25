<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('refresh:0;url=signin.html');
    exit();
}
include "../settings/database.php";

// Mensaje de notificación al activar/inactivar
if (isset($_GET['msg'])) {
    echo "<div class='alert alert-success text-center'>" . $_GET['msg'] . "</div>";
}

// ✅ SOLO SI ES ADMIN, cargamos los usuarios
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

    $sql = "SELECT
        id,
        firstname || ' ' || lastname as fullname,
        email,
        mobile_phone,
        case when status = 't' then 'Active' else 'Inactive' end as status,
        url_photo
    FROM users";

    $params = array();

    if ($filter == 'active') {
        $sql .= " WHERE status = $1";
        $params[] = 't';
    } elseif ($filter == 'inactive') {
        $sql .= " WHERE status = $1";
        $params[] = 'f';
    }

    $res = pg_query_params($local_conn, $sql, $params);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Store - List Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container py-5">

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>

        <!-- ✅ SOLO ADMIN: ve todo esto -->
        <h2 class="text-center mb-4 fw-bold text-dark">List of Users</h2>
        <a href="logout.php" class="btn btn-danger float-end">Cerrar Sesión</a>
        
        <div class="card p-4">
            <div class="mb-4">
                <label class="form-label fw-semibold">Filter users:</label>
                <select class="form-select" onchange="window.location = this.value;">
                    <option value="list_users.php?filter=all">Select a filter</option>
                    <option value="list_users.php?filter=all">List all users</option>
                    <option value="list_users.php?filter=active">List active users only</option>
                    <option value="list_users.php?filter=inactive">List inactive users only</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Photo</th>
                            <th>FullName</th>
                            <th>Email</th>
                            <th>Mobile Phone</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php while ($row = pg_fetch_assoc($res)) { ?>
<tr>
    <td>
        <img src="<?php echo $row['url_photo']; ?>" width="40" class="rounded-circle" alt="User photo">
    </td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['mobile_phone']; ?></td>
    <td>
        <?php if ($row['status'] == 'Active') { ?>
            <span class="badge bg-success">Active</span>
        <?php } else { ?>
            <span class="badge bg-secondary">Inactive</span>
        <?php } ?>
    </td>
    <td>
        <!-- Editar -->
        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="m-2">
            <img src="icons/edit.png" width="18" alt="Edit">
        </a>

        <!-- Borrar -->
        <a href="delete_user.php?id=<?php echo $row['id']; ?>" class="m-2">
            <img src="icons/delete.png" width="18" alt="Delete">
        </a>

        <!-- Activar / Desactivar -->
        <a href="update_user_status.php?id=<?php echo $row['id']; ?>">
            <?php if ($row['status'] == 'Active') { ?>
                <img src="icons/disable.png" width="18" alt="Disable">
            <?php } else { ?>
                <img src="icons/enable.png" width="18" alt="Enable">
            <?php } ?>
        </a>
    </td>
</tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php } else { ?>

        <!-- ⚠️ USUARIO NORMAL: solo ve este mensaje -->
        <div class="card p-4 text-center">
            <h3 class="text-warning mb-3">⚠️ No eres administrador</h3>
            <p class="text-muted mb-4">No tienes permiso para ver esta página.</p>
            <a href="home.php" class="btn btn-primary">Ir al inicio</a>
        </div>

    <?php } ?>

    </div>
</body>
</html>
