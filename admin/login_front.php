<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="loginpage_assets/images/icons/favicon.ico"/>
    <style>
        /* Body Background with Gradient */
        body {
            background: linear-gradient(45deg, #3498db, #8e44ad);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Centered Form */
        .container-login100 {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Floating Form Card */
        .wrap-login100 {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        /* Form Title */
        .login100-form-title {
            font-size: 24px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Input Styles */
        .wrap-input100 {
            margin-bottom: 20px;
            position: relative;
        }

        .input100 {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input100:focus {
            border-color: #3498db;
        }

        /* Button Styles */
        .login100-form-btn {
            width: 100%;
            padding: 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login100-form-btn:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }

        /* Focus effect on input fields */
        .focus-input100::after {
            content: '';
            position: absolute;
            background-color: #3498db;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .input100:focus + .focus-input100::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <span class="login100-form-title">
                    Admin Login
                </span>
                <form class="login100-form validate-form" action="controller\login_controller.php" method="POST" autocomplete="off">
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="username" placeholder="Username" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <input class="login100-form-btn" type="submit" name="login" value="SIGN IN">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Add smooth transition for form elements
        $(document).ready(function() {
            // Animate the input fields and button on focus/blur
            $('.input100').on('focus', function() {
                $(this).parent().find('.focus-input100').css('opacity', '1');
            }).on('blur', function() {
                $(this).parent().find('.focus-input100').css('opacity', '0');
            });

            // Form validation (for enhanced UX)
            $('form').on('submit', function(event) {
                var isValid = true;
                $(this).find('.input100').each(function() {
                    if ($(this).val() === '') {
                        isValid = false;
                        $(this).addClass('error');
                        alert('Please fill out all fields!');
                    } else {
                        $(this).removeClass('error');
                    }
                });
                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
