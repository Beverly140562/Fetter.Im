
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetter | Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>

<?php 

?>
<div class="text-center ">
         <img src="images/Logofetter.png">
    </div>

    <div class="container">
        <form action="actions/login_action.php" method="post">
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
            <p class="mt-3"><a href="register.php">Sign-up</a></p>
            <p class="mt-5 mb-3 text-body-secondary">© 2024–2024</p>
        </form>
            <div class="p-1 text-white"><p>Not registered yet <a href="signup.php">Registration Here</a></p></div>
    </div>


    <script src="js/common.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>