<!-- edit_user.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once '../config/database.php';
    require_once 'User.php';

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $userId = $_GET['id'];
    $userData = $user->read($userId);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = !empty($_POST['password']) ? $_POST['password'] : null;

        if ($user->update($userId, $username, $email, $password)) {
            echo "User updated successfully!";
            header("Location: view_users.php");
        } else {
            echo "Failed to update user.";
        }
    }
    ?>

    <form action="edit_user.php?id=<?php echo $userId; ?>" method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $userData['username']; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $userData['email']; ?>" required><br>

        <label>Password (leave blank to keep current):</label>
        <input type="password" name="password"><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
