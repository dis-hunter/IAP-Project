<!-- view_users.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users</title>
</head>
<body>
    <h2>Users List</h2>

    <?php
    require_once '../config/database.php';
    require_once 'User.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $stmt = $db->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo "<table border='1'>
                <tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>";

        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user['id']}</td>
                    <td>{$user['username']}</td>
                    <td>{$user['email']}</td>
                    <td>
                        <a href='edit_user.php?id={$user['id']}'>Edit</a> |
                        <a href='delete_user.php?id={$user['id']}'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }
    ?>
</body>
</html>
