<?php

require_once 'db_connect.php';

session_start();

function handleException($message) {
    $_SESSION['error'] = $message;
    header('Location: dash-user.php');
    exit();
}

function validateImage($file) {
    $filename = $file['name'];
    $tmp_name = $file['tmp_name'];
    $size = $file['size'];
    $error = $file['error'];
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed_extensions = ['jpg', 'png', 'jpeg', 'gif'];

    if ($error === UPLOAD_ERR_OK) {
        if ($size > 100000) {
            handleException('Error - File Size too Large');
        }

        if (!in_array($extension, $allowed_extensions)) {
            handleException('Error - Wrong File Type');
        }

        return true;
    }

    return false;
}


if (isset($_POST['add'])) {
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $user_role = $_POST['user_role'];

    $file = $_FILES['user-image'];

    if (!empty(trim($fullname))  && !empty(trim($password)) && !empty(trim($tel))){
    if (isset($file['tmp_name']) && validateImage($file)) {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $unique_filename = 'pic_' . uniqid() . '.' . $extension;
        $upload_path = 'images/users/' . $unique_filename;


        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $stmt = $conn->prepare('INSERT INTO `user`(`fullname`, `email`, `password`, `tel`, `user_role`, `user_image`) VALUES (:fullname,:email,:password,:tel, :user_role, :user_image)');

            try {
                $stmt->execute([
                    ':fullname' => $fullname,
                    ':password' => $hashed_password,
                    ':tel' => $tel,
                    ':email' => $email,
                    ':user_role' => $user_role,
                    ':user_image' => $upload_path
                ]);

                $_SESSION['success'] = 'New user added';
                header('Location: dash-user.php');
                exit();
            } catch (PDOException $ex) {
                handleException('User not added - ' . $ex->getMessage());
            }
        }
    } else {
        handleException('Error uploading user image');
    }
}
else {
    handleException('One or More fields are empty');
}

}




if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $user_role = $_POST['user_role'];

    $stmt = $conn->prepare('SELECT * FROM user WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        handleException('Error - User Not Found ' . $id);
        exit();
    }

    if ($_FILES['user-image']['tmp_name'] && validateImage($_FILES['user-image'])) {
        $file = $_FILES['user-image'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $upload_path = 'images/users/pic_' . uniqid() . '.' . $extension;


        if (move_uploaded_file($file['tmp_name'], $upload_path)) {

            unlink($user['user_image']);

            $stmt = $conn->prepare('UPDATE `user` SET `user_image`=:user_image WHERE `id`=:id');
            $stmt->execute([
                ':user_image' => $upload_path,
                ':id' => $id
            ]);
        } else {
            handleException('Error uploading user image');
            exit();
        }
    }


    if (!empty(trim($_POST['password']))) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE `user` SET `fullname`=:fullname, `password`=:password, `tel`=:tel, `email`=:email, `user_role`=:user_role WHERE `id`=:id');
        $stmt->bindParam(':password', $password);
    } else {
        if (!empty(trim($fullname)) && !empty(trim($tel))) {
            $stmt = $conn->prepare('UPDATE `user` SET `fullname`=:fullname, `tel`=:tel, `email`=:email, `user_role`=:user_role WHERE `id`=:id');
        } else {
            handleException('One or More fields are empty');
            exit();
        }
    }

    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_role', $user_role);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['success'] = 'User Updated Successfully';
    header('Location: dash-user.php');
    exit();
}






if (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $user_image = $_POST['user-image-delete'];

    $stmt = $conn->prepare('DELETE FROM `user` WHERE `id`=:id');

    try {
        if ($stmt->execute([':id' => $id])) {
            if (file_exists($user_image)) {
                unlink($user_image);
            }

            $_SESSION['success'] = 'User deleted';
            header('Location: dash-user.php');
        } else {
            handleException('User not deleted');
            header('Location: dash-user.php');
        }
    } catch (PDOException $ex) {
        handleException('User not deleted - ' . $ex->getMessage());
        header('Location: dash-user.php');
    }
}

?>
