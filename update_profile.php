<?php
require_once 'db_connect.php';
session_start();

if (!isset($_POST['update'])) {
    header('Location: profile.php');
    exit();
}

$email = $_POST['email'];
$fullname = $_POST['fullname'];
$telephone = $_POST['telephone'];
$profilePicture = $_FILES['profile-picture'];

// Fetch the existing user data
$stmt = $conn->prepare('SELECT * FROM user WHERE email = :email');
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = 'User not found.';
    header('Location: profile.php');
    exit();
}

$profilePicturePath = $user['user_image'];

if ($profilePicture['size'] > 0) {
    $extension = pathinfo($profilePicture['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($extension, $allowed_extensions)) {
        $_SESSION['error'] = 'Invalid file type.';
        header('Location: profile.php');
        exit();
    }

    $unique_filename = 'pic_' . uniqid() . '.' . $extension;
    $upload_path = 'images/users/' . $unique_filename;

    if (move_uploaded_file($profilePicture['tmp_name'], $upload_path)) {
        if (file_exists($profilePicturePath)) {
            unlink($profilePicturePath);
        }
        $profilePicturePath = $upload_path;
    } else {
        $_SESSION['error'] = 'Error uploading profile picture.';
        header('Location: profile.php');
        exit();
    }
}

$stmt = $conn->prepare('UPDATE user SET fullname = :fullname, tel = :telephone, user_image = :profile_picture WHERE email = :email');
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':telephone', $telephone);
$stmt->bindParam(':profile_picture', $profilePicturePath);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    $_SESSION['fullname'] = $fullname;
    $_SESSION['tel'] = $telephone;
    $_SESSION['profile_picture'] = $profilePicturePath;
    $_SESSION['success'] = 'Profile updated successfully.';
} else {
    $_SESSION['error'] = 'Error updating profile.';
}

header('Location: profile.php');
exit();
?>