<!DOCTYPE html>
<html lang="en">
<?php



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
                                <label for="email">
                                    Email
                                </label>
                                <input type="email" name="email" class="form-control" id="email" value="<?php if (isset($_COOKIE["email"])) {
                                                                                                            echo $_COOKIE["email"];
                                                                                                        } ?>" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    Password
                                </label>
                                <input type="password" name="password" class="form-control" id="password" value="<?php if (isset($_COOKIE["password_hash"])) {
                                                                                                                        echo $_COOKIE["password_hash"];
                                                                                                                    } ?>" placeholder="Password" required />
                            </div>

                            <div class="form-group" style="text-align:left;">
                                <label><input type="checkbox" name="remember" <?php
                                                                                if (isset($_COOKIE["remember"])) {
                                                                                    echo "checked";
                                                                                }


                                                                                ?>> Remember me </label>
                            </div>
                            <button class="btn btn-danger" name="login">
                                Login
                            </button>
                        </form>
                        <p class="mt-3">
                            Not registered?
                            <a href="register_get">Create an
                                account</a>
                        </p>
                        <span> <?php
                                session_start();

                                // $_SESSION["message"];
                                if (isset($_COOKIE["message"])) {
                                    echo $_COOKIE["message"];
                                } else {
                                    //echo "Everything is fine";
                                }

                                ?> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>