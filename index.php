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
        
        <div class="container">
            <div class="jumbotron">
                <h1>Welcome to spieltagtipp.de</h1>
                <p class="lead">This is just a test Text<br>feel free to change.</p>
                <p><button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#LoginModal">Login</button> 
                    <a class="btn btn-primary btn-lg" onClick='window.location.href = "register.php" '>Register</a></p>
            </div>
        </div><!-- /.container -->
        <!-- Modal -->
        <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="form-horizontal" action="UserApplication.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Login</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group<?= ($validator->getError("useremail") != "") ? " has-error" : "" ?>">
                        <label for="Name" class="col-lg-2 control-label" >
                            Email<?= ($validator->getError("useremail") != "") ? " - " . $validator->getError("useremail") : "" ?>
                        </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="useremail" name="useremail" placeholder="useremail" value="<?= $validator->getValue("username") ?>">
                        </div>
                    </div>
                    <div class="form-group<?= ($validator->getError("password") != "") ? " has-error" : "" ?>">
                        <label for="inputPassword" class="col-lg-2 control-label">
                            Password<?= ($validator->getError("password") != "") ? " - " . $validator->getError("password") : "" ?>
                        </label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked id="rememberme" name="rememberme"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="login" value="1">
                        <button class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
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
