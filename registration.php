
<?php
    ini_set("display_errors", 1);
    ini_set("error_reporting", E_ALL);
    print_r($_POST);    
?>

<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body>

<div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
<form method="POST" action=<?php print($_SERVER["PHP_SELF"]); ?>>

    <!--name-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-name" class="form-label">Name</label>
      <input type="text" class="form-control" id="registration-name" required aria-describedby="name-validation">
      <div id="name-validation" class="invalid-feedback">Name is required</div>
    </div>

    <!--email-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-emil" class="form-label">Email</label>
      <input type="email" class="form-control" id="registration-email" required aria-describedby="email-validation">
      <div id="email-validation" class="invalid-feedback">Email is not formatted correctly</div>
    </div>

    <!--password-->
    <div class="sm:container" style="padding:10px">
      <label for="registration-password" class="form-label">Password</label>
      <input type="password" class="form-control" id="registration-password" required aria-describedby="password-validation">
      <div id="password-validation" class="invalid-feedback">Password must be at least 8 characters long</div>
    </div>

    <!--password confirmation-->
    <div class="sm:container" style="padding:10px">
      <label for="confirmation-password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="confirmation-password" required aria-describedby="password-confirmation-validation">
      <div id="password-confirmation-validation" class="invalid-feedback">Passwords must coincide</div>
    </div>

    <div class="sm:container" style="padding:10px">
        <button type="submit" class="btn-solid theme-success">Register</button>
    </div>
</form>
</div>

</body>
</html>