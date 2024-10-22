

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}

.login-container {
    display: flex;
    width: 80%;
    max-width: 1500px;
    height: 80vh;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
}

.login-box {
    background-color: white;
    padding: 20px;
    width: 40%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    position: relative;
}

.login-form-container {
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    background-color: #f9f9f9;
}

.login-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.login-header h2 {
    font-size: 2em;
    margin-right: 10px;
}

.seal-image {
    width: 100px;
}

.input-group {
    width: 95%;
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.remember-me {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.remember-me input {
    margin-right: 5px;
}

.login-button {
    background-color: #3399cc;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

footer {
    margin-top: 20px;
}

footer p {
    font-size: 12px;
    color: #666;
}

footer a {
    text-decoration: none;
    color: #007BFF;
}

.image-side {
    width: 60%;
    position: relative;
}

.background-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

</style>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>LOGIN</h2>
                    <img src="img/cclogo.png" alt="Logo" class="seal-image">
                </div>
                <form method="POST" action="login.php">
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
                    <button type="submit" class="login-button">Login</button>
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
