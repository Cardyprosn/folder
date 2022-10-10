<?php session_start(); ?>
<?php $_SESSION['mail_T'] = 'ousmane@gmail.com'; ?>
<?php include('base.folder/linkbd.php'); ?>
<?php include('function.folder/connexion_function.php') ?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css.folder/style.css" />
    <title>Connexion & inscription</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="connexion.php" method="POST" class="sign-in-form">
                    <h2 class="title">Connexion</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input <?php if (isset($_SESSION['mail_T'])): ?> style="background: rgba(0, 0, 0, 0.10);" readonly value="<?php echo $_SESSION['mail_T']; ?>"<?php endif ?> name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input required name="password" type="password" placeholder="Mot de passe" />
                        <br>
                        <span class="alertPass" style="color: red; font-size: 13px;"></span>
                    </div>
                    <input name="connect" type="submit" value="Connexion" class="btn solid" />
                    <p class="social-text">Contactez-nous sur reseaux</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>
               
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Verifier votre identité</h3>
                    <p>
                         Nous venons de vous envoyé un email a l'adresse <strong><?php echo $_SESSION['mail_T']; ?></strong>, veuiller nous renseigner le code de verification qui s-y trouve ou cliquer sur le boutton pour verifier votre identité
                    </p>
                    
                </div>
                <img src="images/log.png" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Deja membre ? </h3>
                    <p>
                       Si vous étes deja membre nous vous invitons a vous connecter.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Connexion
                    </button>
                </div>
                <img src="images" class="image" alt="" />
            </div>
        </div>
    </div>

    <script sr="javascript.folder/app.js" defer>
        const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});
// fonction a executer si l'utilisateur veux creer un comnpte
function create_account_animation (){
     container.classList.add("sign-up-mode");
}
// fonction a executer si l'utilisateur veux acceder a son comnpte
function acces_account_animation (){
    container.classList.remove("sign-up-mode");
}
    </script>

</body>

</html>

