<!DOCTYPE html>
<html lang="en">
<?php
//session_start();

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, 
                   initial-scale=1,
                   shrink-to-fit=no" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <title>Bootstrap Form</title>
</head>

<body>
    <h1 class="text-success text-center">

        Book LE THE TUAN

    </h1>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= BASE_PATH ?>/login_post" method="post">
                            <div class="form-group">
                                <div>
                                    <span style="color: red;"> <?php
                                                                // $_SESSION["message"];
                                                                if (isset($_SESSION["email_error"])) {
                                                                    echo $_SESSION["email_error"];
                                                                    unset($_SESSION["email_error"]); // delete sesion này
                                                                } else {
                                                                }
                                                                ?> </span>
                                </div>


                                <label for="email">
                                    Email
                                </label>
                                <input type="" name="email" class="form-control" id="email" />
                            </div>




                            <div class="form-group">
                                <div>
                                    <span style="color: red;"> <?php
                                                                // $_SESSION["message"];
                                                                if (isset($_SESSION["password_error"])) {
                                                                    echo $_SESSION["password_error"];
                                                                    unset($_SESSION["password_error"]); // delete sesion này
                                                                } else {
                                                                }
                                                                ?> </span>
                                </div>


                                <label for="password">
                                    Password
                                </label>
                                <input type="password" name="password" class="form-control" id="password" />
                            </div>

                            <div class="form-group" style="text-align:left;">
                                <label><input type="checkbox" name="remember"> Remember me </label>
                            </div>
                            <button class="btn btn-danger" name="login">
                                Login
                            </button>
                        </form>
                        <span id="error_message" style="color: red;"></span>
                        <p class="mt-3">
                            Not registered?
                            <a href="register">Create an
                                account</a>
                        </p>
                        <span> <?php

                                // $_SESSION["message"];
                                if (isset($_SESSION["message"])) {
                                    echo $_SESSION["message"];
                                    unset($_SESSION["message"]); // delete sesion này
                                } else {
                                }

                                ?> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>