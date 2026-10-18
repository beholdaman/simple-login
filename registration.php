
<?php
    ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
    print_r($_POST);    
?>

<?php
$name_err = false;
if( isset($_POST) && isset($_POST["registration-name"])) {
    if( ( $_POST["registration-name"] != "") ) {
        $name_err = false;
    }else{
        $name_err = true;
    }
}

$email_err = false;
if( isset($_POST) && isset($_POST["registration-email"])) {
    if(filter_var($_POST["registration-email"], FILTER_VALIDATE_EMAIL) ) {
        $email_err = false;
    }else{
        $email_err = true;
    }
}

$password_err = false;
if( isset($_POST) && isset($_POST["registration-password"])) {
    if(strlen($_POST["registration-password"]) >=8 ) {
        $password_err = false;
    }else{
        $password_err = true;
    }
}

$password2_err = false;
if( isset($_POST) && isset($_POST["confirmation-password"]) && ($_POST["registration-password"])) {
    if(($_POST["confirmation-password"])==$_POST["registration-password"] ) {
        $password2_err = false;
    }else{
        $password2_err = true;
    }
}

$errors = ( ($name_err || $email_err || $password_err || $password2_err) && 
            (isset($_POST) && isset($_POST["registration-name"]) && (isset($_POST["registration-email"])) 
             && (isset($_POST["registration-password"])) && (isset($_POST["confirmation-password"])) ) );


?>

<!DOCTYPE html>
<html>
<head>
    <title>registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>

<div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">

<?php if(!$errors) { ?>
<div class="sm:container" style="padding:10px">
<p class="bg-success fg-contrast-success">Registration of user was successful</p>
</div>
<?php }?>

<form method="POST"  novalidate="true" action=<?php print($_SERVER["PHP_SELF"]); ?>>

    <!--name-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-name" class="form-label">Name</label>
      <input name="registration-name" type="text" class="form-control" id="registration-name">
      <?php if($name_err) {?>
      <div name="name-validation-danger" id="name-validation" class="form-text">Name is required</div>
      <?php }?>
   
    </div>

    <!--email-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-email" class="form-label">Email</label>
      <input name = "registration-email" type="email" class="form-control" id="registration-email" required aria-describedby="email-validation">
      <?php if($email_err) { ?>
      <div id="email-validation" class="form-text">Email is not formatted properly</div>
      <?php }?>
    </div>

    <!--password-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-password" class="form-label">Password</label>
      <input name="registration-password" type="password" class="form-control" id="registration-password" required aria-describedby="password-validation">
      <?php if($password_err) { ?>
      <div id="password-validation" class="form-text">Password must be at least 8 characters long</div>
      <?php }?>
    </div>

    <!--password confirmation-->
    <div class="sm:container" style="padding:10px">
      <label for="confirmation-password" class="form-label">Confirm Password</label>
      <input name="confirmation-password" type="password" class="form-control" id="confirmation-password" required aria-describedby="password-confirmation-validation">
      <?php if($password2_err) { ?>
      <div id="password-confirmation-validation" class="form-text">Passwords must coincide</div>
      <?php } ?>
    </div>

    <div class="sm:container" style="padding:10px">
        <button type="submit" class="btn-solid theme-success">Register</button>
    </div>
</form>
</div>

</body>
</html>