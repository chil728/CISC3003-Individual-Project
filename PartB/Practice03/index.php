<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chan Hin Ieong DC226696</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <nav>
            <ul class="menu-member">
                <?php
                if (isset($_SESSION["useruid"])) {
                ?>
                    <li><a href="#"><?php echo $_SESSION["useruid"]; ?></a></li>
                    <li><a href="includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
                <?php
                } else {
                ?>
                    <li><a href="#">Sign Up</a></li>
                    <li><a href="#" class="header-login-a">Login</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>

    <?php if (!isset($_SESSION['useruid'])): ?>
    <section class="wrapper">
        <div class="index-login-signup">
            <div class="form-toggle">
                <button id="signup-toggle" class="active">Sign Up</button>
                <button id="login-toggle">Login</button>
            </div>
            <div class="form-content">
                <div class="form-signup active">
                    <h4>SIGN UP</h4>
                    <p>Don't have an account yet? Sign up here!</p>
                    <form action="includes/signup.inc.php" method="post">
                        <input type="text" name="uid" placeholder="Username">
                        <input type="password" name="pwd" placeholder="Password">
                        <input type="password" name="pwdRepeat" placeholder="Repeat Password">
                        <input type="text" name="email" placeholder="E-mail">
                        <button type="submit" name="submit">SIGN UP</button>
                    </form>
                </div>
                <div class="form-login">
                    <h4>LOGIN</h4>
                    <p>Already have an account? Login here!</p>
                    <form action="includes/login.inc.php" method="post">
                        <input type="text" name="uid" placeholder="Username">
                        <input type="password" name="pwd" placeholder="Password">
                        <button type="submit" name="submit">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script>
        const signupToggle = document.getElementById('signup-toggle');
        const loginToggle = document.getElementById('login-toggle');
        const signupForm = document.querySelector('.form-signup');
        const loginForm = document.querySelector('.form-login');

        signupToggle.addEventListener('click', () => {
            signupForm.classList.add('active');
            loginForm.classList.remove('active');
            signupToggle.classList.add('active');
            loginToggle.classList.remove('active');
        });

        loginToggle.addEventListener('click', () => {
            loginForm.classList.add('active');
            signupForm.classList.remove('active');
            loginToggle.classList.add('active');
            signupToggle.classList.remove('active');
        });
    </script>
</body>

</html>