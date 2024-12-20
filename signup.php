
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetter | Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signup.css" rel="stylesheet">

</head>
<body>


    <div class="h1 text-center" >
         <img src="images/Logofetter.png">
    </div>

    

    <div class="container rounded " style="box-shadow: 5px 5px 1px lightgrey;">
                

        <h3 class=" text-center fw-bold">Create new account</h3>
        <h4 class=" text-center fs-5 p-1">It's quick and <br> easy.</h4>
        <form action="actions/signup_action.php" method="post">
           
   

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Name" name="name">
                <label for="floatingInput">Name</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Name" name="username">
                <label for="floatingInput">Username</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Register</button>
            <p class="btn text-dark fw-bold">© 2024–2024</p>
        </form>
    </div>

    
    <div class="container p-1 text-white" style="max-width: 500px;">
    <p>People who use our service may have uploaded your <br> contact information to Fetter.</p>
    </div>

    <div class="text-center text-white ">
        <div><p>Already registered <a href="login.php">Login Here</p></div>
    </div>
    
    <script src="js/common.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>