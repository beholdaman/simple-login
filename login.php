<?php
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
print_r($_POST);
print_r($_COOKIE);  

include_once("functions.php");
?>

<?php
session_start();
print_r($_SESSION);



$logged = NULL;
$error_msg = NULL;


//l'email è sbagliata se è stata inserita ma non è nel formato corretto
$email_err = false;
if( isset($_POST) && isset($_POST["input-email"])) {
    $email_err = !(filter_var($_POST["input-email"], FILTER_VALIDATE_EMAIL));
}

//la password è sbagliata solo se vuota
$password_err = false;
if( isset($_POST) && isset($_POST["input-password"])) {
    $password_err = (empty($_POST["input-password"]));
}


$db = open_mysql_connection();

//si tenta il login solo se i campi sono compilati correttamente
if( (isset($_POST)) && (!empty($_POST["input-email"])) && ($_POST["input-password"]) && (!$email_err) && (!$password_err)) {


    $logged = check_login($db, $_POST["input-email"], md5($_POST["input-password"]));
    //se il login fallisce si incrementa il numero dei fallimenti
    if(empty($logged)) {
        $error_msg = "Failed to log in";
        $login_failure = true;
        $_SESSION["login-errors"] = $_SESSION["login-errors"] + 1;

        if($_SESSION["login-errors"] >= 5) {
            $_SESSION["timeout"] = time() + 60; //1 minuto di timeout
            $error_msg = "Failed to log in 5 times. 1 minute timeout";
        }
    }else{
        $_SESSION["login-errors"] = 0;
    }

}


if(isset($_SESSION["log-person"])) {
    $logged = $_SESSION["log-person"];
}

if(isset($logged)) {
    $_SESSION["log-person"] = $logged;
}

//si disabilita il login se si sono fatti 5 o pi errori e il tempo di timeout non è scaduto
$disable_login = (!empty($_SESSION["login-errors"]) && (!empty($_SESSION["timeout"])) 
    && ($_SESSION["login-errors"] >= 5) && ($_SESSION["timeout"] > time()) );

//logout su richiesta
if(isset($_GET) && (!empty($_GET["logout"])) && ($_GET["logout"]) ) {
    //se non si è chiesto di ricordare si eliminano i cookie
    if(isset($_POST) && (empty($_POST["remember-me"])) ) {
        unset($_COOKIE["email"]);
        setcookie("email", "", time()-1, "/login/", "localhost", true, true);
        unset($_COOKIE["password"]);
        setcookie("password", "", time()-1, "/login/", "localhost", true, true);
    }
    unset($_SESSION["log-person"]);
    $logged = NULL;
}

//si caricano i cookie se si è fatto login con successo e si è richiesto di ricordare
if(isset($_POST) && (!empty($_POST["remember-me"])) && ($_POST["remember-me"]) && (!empty($logged) ) ) {

    setcookie("email", $logged["email"], time()+60*60*24*30, "/login/", "localhost", true, true);
    setcookie("password", $logged["password"], time()+60*60*24*30, "/login/", "localhost", true, true);

}
//si tenta il login con i cookie salvati se presenti
if(isset($_COOKIE) && (!empty($_COOKIE["email"])) && (!empty($_COOKIE["password"])) ) {
   $logged = check_login($db, $_COOKIE["email"], $_COOKIE["password"]);
}

mysqli_close($db);

?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>

<?php if(empty($logged)) { ?>
    <div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
    <form action= <?php print($_SERVER["PHP_SELF"]);?> method="POST">

    <?php if(!empty($error_msg)) { ?>
        <div class="sm:container" style="padding:10px">
        <p class="bg-danger fg-contrast-danger"><?php print($error_msg); ?></p>
        </div>
    <?php } ?>


        <div class="sm:container" style="padding:10px">
            <label for="input-email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="input-email" name="input-email" aria-describedby="emailHelp" placeholder="name@example.com" 
                value= <?php
                if( (isset($_POST)) &&  (!(empty($_POST["input-email"]))) ) {
                    print($_POST["input-email"]);
                }
                ?>>
            <?php if($email_err) { ?>
               <div id="email-validation" class="form-text">Email is not formatted properly</div>
            <?php }?>
        </div>
        <div class="sm:container" style="padding:10px">
            <label for="input-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="input-password" name="input-password">
            <?php if($password_err) { ?>
               <div id="password-validation" class="form-text">Insert a password</div>
            <?php }?>
        </div>

        <div class="sm:container" style="padding-left:10px; padding-right:10px; padding-bottom:10px">
        <a class="theme-success underline-success underline-20 hover:underline-100" href="reset.php">Reset your password</a>
        </div>

        <div class="form-field" style="padding:10px">
            <input name="remember-me" type="checkbox" id="checksuccess" class="check theme-success" unchecked  value="true"/>
            <label for="checksuccess">Remember me</label>
        </div>

        <div class="sm:container" style="padding:10px">
            <button type="submit" class="btn-solid theme-success" <?php if($disable_login) { print("disabled"); } ?>>Log In</button>
        <a href="registration.php"><button type="button" formaction= "registration.php" class="btn-outline theme-success">Registration</button></a>
        </div>

    </form>
    </div>
<?php }else{ ?>
    <div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
        <p>Welcome, <?php print($logged["name"]); ?></p>
        <p>Email: <i><?php print($logged["email"]); ?> </i></p>
        <a href="login.php?logout=true"><button type="button" class="btn btn-link theme-danger" style="padding:0px">Logout</button></a>
    </div>
<?php } ?>
</body>
</html>