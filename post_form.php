
<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

// Database connection
include 'actions/database.php';  // Make sure your database connection is correct

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['text'];  // Get the text input from the form
    $user_id = $user['id'];  // Get the user's ID

    // Initialize the image name as null (for text-only posts)
    $image_name = null;

    // If an image is uploaded, handle it
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = 'uploads/' . $image_name;

        // Move the uploaded image to the "uploads" folder
        move_uploaded_file($image_tmp, $image_path);
    }

    // Insert the post data into the database
    $sql = "INSERT INTO posts (userid, text, image, created_at) VALUES (:userid, :text, :image, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userid', $user_id);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':image', $image_name);  // This can be null if no image is uploaded

    if ($stmt->execute()) {
        header('Location: profile.php');  // Redirect to profile page after posting
        exit();
    }
}
?>