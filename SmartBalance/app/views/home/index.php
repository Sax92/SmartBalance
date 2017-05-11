<?php include 'Header.php'; ?>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h1 class="text-center">SmartBalance</h1>
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" required placeholder="E-mail" id="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required placeholder="Password" id="password" type="password">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input id="remember" type="checkbox" value="remember">Ricordami
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button id="login" type="button" class="btn btn-lg btn-success btn-block">Login</button>
                                <br>
                                <div class="alert alert-danger hide"></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <p>SmartBalance - © developed by Mancinelli Edoardo, Pagliaccia Michele, Benzoni Sasha</p>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$config['js']?>metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script src="<?=$config['js']?>Home/login.js"></script>

</body>

</html>
