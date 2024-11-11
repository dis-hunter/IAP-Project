<!-- delete_user.php -->
<?php
require_once '../config/database.php';
require_once 'User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    if ($user->delete($userId)) {
        echo "User deleted successfully!";
    } else {
        echo "Failed to delete user.";
    }
}

// Redirect back to view_users.php after deletion
header("Location: view_users.php");
exit;
?>
