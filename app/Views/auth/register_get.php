<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
    </script>
</head>

<body>
    <h1 class="text-success text-center">
        GeeksforGeeks
    </h1>
    <h2 class="text-center">Stacked form</h2>
    <div class="container">
        <form action="<?= BASE_PATH ?>/register_post" method="post">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter First Name" name="name">
            </div>
            <div class="form-group">
                <label for="Address">Address</label>
                <input type="Address" class="form-control" id="Address" placeholder="Enter Address" name="Address">
            </div>

            <div class="form-group">
                <label for="email ">Email :</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email">
            </div>

            <div class="form-group">
                <label for="contact">Contact :</label>
                <input type="text" class="form-control" id="contact" placeholder="Enter Contact Number" name="contact">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
            </div>
            <button type="submit" class="btn bg-success">
                Submit
            </button>

            <h1 style="color:red">
                <?php
                if (isset($_SESSION['error_password'])) {
                    echo $_SESSION['error_password'];
                    unset($_SESSION['error_password']);
                }
                if (isset($_SESSION['error_email'])) {
                    echo $_SESSION['error_email'];
                    unset($_SESSION['error_email']);
                }
                ?>
            </h1>
        </form>
    </div>
</body>

</html>