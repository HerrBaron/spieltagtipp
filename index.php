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
                <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
                <p><a class="btn btn-primary btn-lg" onClick='window.location.href = "login.php" '>Login</a> 
                    <a class="btn btn-primary btn-lg" onClick='window.location.href = "register.php" '>Register</a></p>
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Launch demo modal</button>
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
