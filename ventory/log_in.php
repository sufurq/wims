
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page3</title>
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>LOGIN</h2>
                    <img src="img/cclogo.png" alt="Logo" class="seal-image">
                </div>
                <form action="./logic/login_page_process.php" method="post">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember Me</label>
                    </div>
                    
                    <button type="submit" name="login"class="login-button">Login</button>               
                 </form>
            </div>
            <footer>
                <p>© 2022 - LSB - <a href="#">PRIVACY</a></p>
            </footer>
        </div>
        <div class="image-side">
            <img src="img/city_hall.png" alt="City Hall" class="background-image">
        </div>
    </div>
</body>
</html>
