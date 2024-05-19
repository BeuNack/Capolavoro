<!DOCTYPE html>
<html>
<head>
    <title>Capolavoro - login</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    </head>
<body>
    <div class="vl"></div>

    <!-- LOGIN -->
    <form class="form" action="controllaUtente.php?reg=n" method="POST">
      <div class="title">Benvenuto!</div>
      <div class="subtitle">Accedi con il tuo account</div>
      <a href="registrazione.php">
        <div class="subtitle-link">Non hai un account?</div>
      </a>
      <div class="input-container ic2">
        <input id="email" name="email" class="input" type="text" placeholder=" " />
        <label for="email" class="placeholder">Email</label>
      </div>
      <div class="input-container ic2">
        <input id="password" name="password" class="input" type="password" placeholder=" " />
        <label for="password" class="placeholder">Password</label>
      </div>
      <button type="text" class="submit">submit</button>
    </form>
</body>
<script>
    // function setupTogglePassword(togglePasswordId, passwordId) {
    //     const togglePassword = document.querySelector(togglePasswordId);
    //     const password = document.querySelector(passwordId);

    //     togglePassword.addEventListener('click', function () {
    //         // Toggle the type attribute
    //         const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    //         password.setAttribute('type', type);

    //         // Toggle the eye slash icon
    //         if (togglePassword.src.match("https://media.geeksforgeeks.org/wp-content/uploads/20210917150049/eyeslash.png")) {
    //             togglePassword.src = "https://media.geeksforgeeks.org/wp-content/uploads/20210917145551/eye.png";
    //         } else {
    //             togglePassword.src = "https://media.geeksforgeeks.org/wp-content/uploads/20210917150049/eyeslash.png";
    //         }
    //     });
    // }

    // setupTogglePassword('#togglePassword_signup', '#id_password_signup');
    // setupTogglePassword('#togglePassword_login', '#id_password_login');
</script>
</html>

