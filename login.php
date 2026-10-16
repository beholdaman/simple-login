<?php
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
    
</head>
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
<body>
    <div class="sm:container" style="padding-right:20%; padding-left:20%; padding-top:10%">
    <form>
        <div class="sm:container" style="padding:10px">
            <label for="input-email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="input-email" aria-describedby="emailHelp" placeholder="name@example.com">
        </div>
        <div class="sm:container" style="padding:10px">
            <label for="input-password" class="form-label">Password</label>
            <input type="password" class="form-control" id="input-password">
        </div>

        <div class="sm:container" style="padding-left:10px; padding-right:10px; padding-bottom:10px">
        <!--button to recover password-->
        <a class= "theme-info underline-offset-2 underline-20 hover:underline-100" href="reset.php" >Reset your password</a>
        </div>

        <div class="sm:container" style="padding:10px">
        <button type="button" class="btn-solid theme-success">Log In</button>
        </div>
    </form>
    </div>
</body>
</html>