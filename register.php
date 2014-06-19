<?php   
    require_once 'UserApplication.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php   
    include_once 'template/include_head.php';
?>
    </head>
    <body>

<?php   
    include_once 'template/include_navbar.php';
?>
        
        <?php
#$dbh = new PDO('mysql:host=localhost;dbname=spieltagtipp', 'root', '');
?>
        
        <div class="container">
            <div class="well">
<?php
    if ($validator->num_errors > 0)
    {
?>
                <div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>Oh snap!</strong> <a href="#" class="alert-link">Change a few things up</a> and try submitting again.<br>
                </div>
<?php
    }
?>
                <form class="form-horizontal" action="UserApplication.php" method="POST">
                <fieldset>
                <legend>Please Register:</legend>  
                    <div class="form-group<?= ($validator->getError("first_name") != "") ? " has-error" : "" ?>">
                        <label for="first_name" class="col-lg-2 control-label" >First name<?= ($validator->getError("first_name") != "") ? " - " . $validator->getError("first_name") : "" ?></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" value="<?= $validator->getValue("first_name") ?>">
                        </div>
                    </div>
                <div class="form-group<?= ($validator->getError("last_name") != "") ? " has-error" : "" ?>">
                        <label for="Name" class="col-lg-2 control-label" >Last name<?= ($validator->getError("last_name") != "") ? " - " . $validator->getError("last_name") : "" ?></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="first_name" name="last_name" placeholder="Last name" value="<?= $validator->getValue("last_name") ?>">
                        </div>
                    </div>
                    <div class="form-group<?= ($validator->getError("username") != "") ? " has-error" : "" ?>">
                        <label for="Name" class="col-lg-2 control-label" >Username<?= ($validator->getError("username") != "") ? " - " . $validator->getError("username") : "" ?></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $validator->getValue("username") ?>">
                        </div>
                    </div>
                    <div class="form-group<?= ($validator->getError("useremail") != "") ? " has-error" : "" ?>">
                        <label for="inputEmail" class="col-lg-2 control-label">Email<?= ($validator->getError("useremail") != "") ? " - " . $validator->getError("useremail") : "" ?></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputEmail" name="useremail" placeholder="Email" value="<?= $validator->getValue("useremail") ?>">
                        </div>
                    </div>
                    <div class="form-group<?= ($validator->getError("password") != "") ? " has-error" : "" ?>">
                        <label for="inputPassword" class="col-lg-2 control-label">Password<?= ($validator->getError("password") != "") ? " - " . $validator->getError("password") : "" ?></label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <input type="hidden" name="register" value="1">
                            <button class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
                </form>
            </div>
        </div><!-- /.container -->
<?php   
    include_once 'template/include_footer.php';
?>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
