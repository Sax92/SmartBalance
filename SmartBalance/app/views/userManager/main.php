<?php
    include 'Header.php';
?>

<body>
    
<body>

    <div id="wrapper">
        <?php
            $menu=new Menu();
            $menu->printMenu();
        ?>
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Riepilogo</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-left fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div>Uscite odierne</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?=$config['path_base']?>expense/">
                            <div class="panel-footer">
                                <span class="pull-left">Vedi dettagli</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ban fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div>Uscite non effettuate</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?=$config['path_base']?>expense/">
                            <div class="panel-footer">
                                <span class="pull-left">Vedi dettagli</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-arrow-right fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div>Entrate odierne</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?=$config['path_base']?>entry/">
                            <div class="panel-footer">
                                <span class="pull-left">Vedi dettagli</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ban fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div>Entrate non ricevute</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?=$config['path_base']?>entry/">
                            <div class="panel-footer">
                                <span class="pull-left">Vedi dettagli</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./row -->
            
            <!-- row-->
            <div class="row">
                <div class="col-sm-4">
                    <h4>Totale Uscite</h4>
                    <h1 id="expenseTot"></h1>
                </div>
                <div class="col-sm-4">
                    <h4>Totale Entrate</h4>
                    <h1 id="entryTot"></h1>
                </div>
                <div class="col-sm-4">
                    <h4>Saldo</h4>
                    <h1 id="saldo"></h1>
                </div>
            </div>
            <!-- ./row -->
            
            <!-- row -->
            <div class="row">
                <div class="col-lg-6">          
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-ban fa-fw"></i> Detrazioni entrate</h3>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detEntrate" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data registrazione</th>
                                        <th>Importo €</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">          
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-ban fa-fw"></i> Detrazioni uscite</h3>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detUscite" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data registrazione</th>
                                        <th>Importo €</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- row -->
            <!-- row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Confronto entrate uscite (anno corrente)</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <canvas id="confronto"></canvas>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
            <!-- ./row -->
            
            <!-- row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Confronto entrate uscite negli anni</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <canvas id="confrontoAnni"></canvas>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
            <!-- ./row -->
            
            <!-- Modal delete-->
            <div id="deleteE" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title">Sei sicuro?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Premere SI per eliminare la voce definitivamente</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger">Sì</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- Modal delete-->
            <div id="deleteU" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title">Sei sicuro?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Premere SI per eliminare la voce definitivamente</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger">Sì</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- /#page-wrapper -->
        <?php include 'Footer.php';?>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$config['js']?>metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="<?=$config['js']?>Chart.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>UserManager/chartMainJS.js"></script>
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>UserManager/userManager.js"></script>


</body>

</html>