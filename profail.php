<?php
require_once 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data from the database
$email = $_SESSION['email'];
$stmt = $conn->prepare('SELECT * FROM user WHERE email = :email');
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = 'User not found.';
    header('Location: dashboard.php');
    exit();
}

$user_fullname = $user['fullname'];
$user_email = $user['email'];
$user_role = $user['user_role'];
$profilePicture = $user['user_image'];
$telephone = $user['tel'];

$manage_users = "";

if ($user_role == 'admin') {
    $manage_users = '<li><a href="dash-user.php"><i class="fas fa-user"></i>Users</a></li>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profail.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <a href="javascript:history.back()" class="back-button">&#8592;</a>
            <div class="profile-picture">
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture">
            </div>
            <div class="profile-details">
                <h2>Full Name: <?php echo $user_fullname; ?></h2>
                <p>Email: <?php echo $user_email; ?></p>
                <?php if (!empty($telephone)): ?>
                    <p>Telephone: <?php echo $telephone; ?></p>
                <?php endif; ?>
                <p>User Role: <?php echo $user_role; ?></p>
                <button id="edit-button">Edit Profile</button>
            </div>
        </div>
        <div class="profile-edit" style="display: none;">
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="email" value="<?php echo $user_email; ?>">
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" value="<?php echo $user_fullname; ?>" required>
                <label for="telephone">Telephone:</label>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" required>
                <label for="profile-picture">Profile Picture:</label>
                <input type="file" name="profile-picture" accept="image/*">
                <div>
                    <button type="submit" name="update">Update Profile</button>
                    <button type="button" id="cancel-button">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('edit-button').onclick = function() {
            document.querySelector('.profile-details').style.display = 'none';
            document.querySelector('.profile-edit').style.display = 'block';
        };
        document.getElementById('cancel-button').onclick = function() {
            document.querySelector('.profile-details').style.display = 'block';
            document.querySelector('.profile-edit').style.display = 'none';
        };
    </script>
</body>
</html>