<?php
    session_start();
    $email = $password = NULL;
    function handle_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_SESSION['id'])) {
        header("Location: ../index.php");
        exit();
    }

    if(isset($_POST["email"]) && isset($_POST["password"])) {
        $email = handle_input($_POST["email"]);
        $password = handle_input($_POST["password"]);

        $users_data = fopen("../data/users.csv", "r");

        while(($user_info = fgetcsv($users_data)) !== FALSE) {
            if($user_info[2] === $email && password_verify($password, $user_info[3])) {
                $_SESSION["id"] = $user_info[0];
                $_SESSION["username"] = $user_info[1];
                break;
            }
        }

        fclose($users_data);
        if(!isset($_SESSION["id"]))
            $_SESSION["error"] = "Email or password incorrect";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/error.css">
</head>
<body>

    <?php if(isset($_SESSION["error"])): ?>
        <div class="error-wrapper">
        <div class="error">
            <div class="info__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m12 1.5c-5.79844 0-10.5 4.70156-10.5 10.5 0 5.7984 4.70156 10.5 10.5 10.5 5.7984 0 10.5-4.7016 10.5-10.5 0-5.79844-4.7016-10.5-10.5-10.5zm.75 15.5625c0 .1031-.0844.1875-.1875.1875h-1.125c-.1031 0-.1875-.0844-.1875-.1875v-6.375c0-.1031.0844-.1875.1875-.1875h1.125c.1031 0 .1875.0844.1875.1875zm-.75-8.0625c-.2944-.00601-.5747-.12718-.7808-.3375-.206-.21032-.3215-.49305-.3215-.7875s.1155-.57718.3215-.7875c.2061-.21032.4864-.33149.7808-.3375.2944.00601.5747.12718.7808.3375.206.21032.3215.49305.3215.7875s-.1155.57718-.3215.7875c-.2061.21032-.4864.33149-.7808.3375z"></path></svg>
            </div>
            <p><?php echo $_SESSION["error"] ?></p>
        </div>
    </div>
    <?php unset($_SESSION["error"]); endif; ?>

    

<!-- From Uiverse.io by andrew-demchenk0 --> 
    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
               <input type="checkbox" class="toggle">
               <span class="slider"></span>
               <span class="card-side"></span>

               <div class="flip-card__inner">

                  <div class="flip-card__front">
                     <div class="title">Log in</div>
                     <form class="flip-card__form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input class="flip-card__input" name="password" placeholder="Password" type="password">
                        <div>
                           <button type="submit" class="flip-card__btn">Let`s go!</button>
                           <button type="reset" class="flip-card__btn">Reset</button>
                        </div>
                     </form>
                  </div>
                  
                  <div class="flip-card__back">
                     <div class="title">Sign up</div>
                     <form class="flip-card__form" method="post" action="register.php">
                        <input class="flip-card__input" name="username" placeholder="Username" type="text">
                        <input class="flip-card__input" name="email" placeholder="Email" type="email">
                        <input class="flip-card__input" name="password" placeholder="Password" type="password">
                        <button class="flip-card__btn">Confirm!</button>
                     </form>
                  </div>
               </div>

            </label>
        </div>   
   </div>

</body>
</html>