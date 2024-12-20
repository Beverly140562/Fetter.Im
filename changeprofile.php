<?php

session_start();
include 'actions/database.php'; 


$user = $_SESSION['user'];

// Handle the profile image change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];

    // Validate file type and size
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 7 * 1024 * 1024; // 7MB

    if (in_array($file['type'], $allowed_types)) {
        if ($file['size'] <= $max_size) {

            // Set up upload directory
            $upload_dir = 'uploads/' . $user['id'] . '/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Generate a unique file name to prevent overwriting
            $file_name = time() . '_' . basename($file['name']);
            $upload_path = $upload_dir . $file_name;

            // Move the uploaded file
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {

                // Update the database with the new profile image
                try {
                    $sql = "UPDATE user SET profile_image = :profile_image WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':profile_image', $file_name);
                    $stmt->bindParam(':id', $user['id']);
                    $stmt->execute();

                    // Update session to reflect the new profile image
                    $_SESSION['user']['profile_image'] = $file_name;

                    // Redirect to the profile page
                    header('Location: profile.php');
                    exit();

                } catch (PDOException $e) {
                    echo "Error updating profile image: " . $e->getMessage();
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "File size is too large. Maximum size is 7MB.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, or GIF images are allowed.";
    }
}


?>

<!-- HTML Form for uploading profile image -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetter |  Change Profile Image </title>
</head>
<body>

    <h2>Change Profile Image</h2>

    <form method="post" enctype="multipart/form-data">
        <label for="profile_image">Upload a Profile Image:</label>
        <input type="file" name="profile_image" id="profile_image" required><br><br>
        <input type="submit" value="Upload Image">
    </form>



</body>
</html>
