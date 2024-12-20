<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];

// Database connection
include 'actions/database.php';
// Make sure your database connection is correct

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetter | Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profilebody.css" rel="stylesheet">
    <style>
        /* Ensuring post width is reasonable */
        .card-body {
            max-width: 400px;
            margin: 0 auto; /* Center the posts */
        }
    </style>
</head>
<body>

<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Fetter</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!-- Profile Section -->
    <div class="container mt-5">
        <h2>Welcome to Fetter, <?php echo ucfirst($user['name']); ?></h2>

        <div style="background-color:white;text-align:center;color:#405d9b;">

                <?php

            //     $image = "images/cover_image.jpg";
                //  if(file_exists($user_data['cover_image']))
                //    {
                //       $image = $image_class->get_thumb_cover($user_data['cover_image']);
                //   }

                ?>


            <span style="font-size:12px;">
            

                    <?php
                        // Display current profile image if exists
                        if (!empty($user['profile_image'])) {
                            
                            echo "<br><img src='uploads/" . $user['id'] . "/" . $user['profile_image'] . "' alt='Profile Image' width='150'>";
                        }
                    ?>
            
                <br>

                <a style="text-decoration:none; color:green;" href="changeprofile.php?change=profile"> Change Profile Image</a>

            </span>

                <div style="font-size:20px; color:black;"><?php echo $user['name'] ?></div>
            <br>

            <a href="timeline.php"><div id="menu_buttons">Timeline</div></a>
            <div id="menu_buttons">About</div>
            <div id="menu_buttons">Friends</div>
            <div id="menu_buttons">Photos</div>

        </div>


        <!-- Post Form -->
        <div class="container mt-5">
            
            <form action="profile.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">                   
                    <textarea name="text" id="text" class="form-control" rows="3" required placeholder="Write something..."></textarea>
                </div>

                <!-- Image input is optional -->
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image (Optional)</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Post</button>
            </form>


        </div>

        <!-- Display User Posts -->
        <div class="mt-5">
            <h6>Your Posts</h6>
                <?php
                // Fetch posts from the database
                    $sql = "SELECT * FROM posts WHERE userid = :userid ORDER BY created_at DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':userid', $user['id']);
                    $stmt->execute();

                    // Display each post
                    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="card mb-4">';
                        echo '<div class="card-body">';
                        if (!empty($user['profile_image'])) {
                            
                            echo "<br><img src='uploads/" . $user['id'] . "/" . $user['profile_image'] . "' alt='Profile Image' width='50' >". " " . $user['name'];
                        }

                            echo '<p><br>' . htmlspecialchars($post['text']) . '</p>';

                        // Display image if available
                        if ($post['image']) {
                            echo '<img src="uploads/' . htmlspecialchars($post['image']) . '" class="img-fluid" alt="Post Image"><br>';
                            echo '<a href="">Like</a> . <a href="">Comment</a> . <span style="color:#999;">' . $post['created_at'] . '</span>';

                        }

                        echo '</div>';
                        echo '</div>';
                    }
                ?>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
