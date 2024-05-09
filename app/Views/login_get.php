<!DOCTYPE html>
<html lang="en">

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
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    Password
                                </label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required />
                            </div>
                            <button class="btn btn-danger">
                                Login
                            </button>
                        </form>
                        <p class="mt-3">
                            Not registered?
                            <a href="register_get">Create an
                                account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>