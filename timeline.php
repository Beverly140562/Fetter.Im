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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="css/profilebody.css" rel="stylesheet">
    <title>Fetter | Timeline</title>
</head>
<body>

<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="profile.php">Fetter</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<!--cover-->

<div style="width:800px; margin:auto;min-height:400px;"><br>

    
    <!--below cover area-->
    <div style="display:flex;">

    <!--friends area-->
        <div style="min-height:400px;flex:1;"><br>

            <div id="friends_bar">
                <br>
                               
                <?php
                // Display current profile image if exists
                    if (!empty($user['profile_image'])) {

                        echo "<br><img src='uploads/" . $user['id'] . "/" . $user['profile_image'] . "' alt='Profile Image' width='150'>";
                    
                    }
                ?>
                <br>
                    <a href="profile.php" style="text-decoration:none;">
                        <?php echo $user['name'];?>
                    </a>

            </div>
        </div>

    <!--post area-->
        <div style="min-height: 400px;flex:2.5; padding:20px; padding-right:0px">

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

    <!--post-->
            <div id="post_bar">
            <!--post 1-->
                <div id="post">
                    
                    <div>
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
                            
                                    echo "<br><img src='uploads/" . $user['id'] . "/" . $user['profile_image'] . "' alt='Profile Image' width='50' >" . " " . $user['name'];
                                }
                                    echo '<p> <br>' . htmlspecialchars($post['text']) . '</p>';

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
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>