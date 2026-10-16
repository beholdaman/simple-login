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
    <form>
        <div class="md:container">
            <label for="input-email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="input-email" aria-describedby="emailHelp">
        </div>
        <div class="md:container">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <!--button to recover password-->
        <div class="md:container">
        <button type="submit" class="btn-solid theme-primary">Submit</button>
        </div>
        
</form>
</body>
</html>