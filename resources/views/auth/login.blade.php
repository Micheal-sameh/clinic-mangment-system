<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .min-vh-100 {
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-center bg-primary text-white py-4">
                        <h3>Login</h3>
                    </div>

                    <div class="card-body p-5">
                        <!-- Error messages -->
                        <div id="error-messages" class="alert alert-danger d-none">
                            <ul id="error-list"></ul>
                        </div>

                        <!-- Login form -->
                        <form id="login-form" method="POST" action="/login">
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" class="form-control" name="email" required autofocus placeholder="Enter your email">
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required placeholder="Enter your password">
                            </div>

                            <div class="form-group form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                                    Login
                                </button>
                            </div>
                        </form>

                        <div class="form-group mt-4 text-center">
                            <a class="btn btn-link" href="/password/reset">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const form = document.getElementById('login-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const errors = [];
            if (!document.getElementById('email').value) {
                errors.push('Email is required.');
            }
            if (!document.getElementById('password').value) {
                errors.push('Password is required.');
            }

            if (errors.length > 0) {
                const errorMessagesDiv = document.getElementById('error-messages');
                const errorList = document.getElementById('error-list');

                errorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });

                errorMessagesDiv.classList.remove('d-none');
            } else {
                form.submit();
            }
        });
    </script>

</body>
</html>
