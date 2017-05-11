<?php
    include 'Header.php';
?>

<body>

    <div id="wrapper">
        <?php
            $menu=new Menu();
            $menu->printMenu();
        ?>
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Gestione uscite</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <button id="aggiungi" data-toggle="modal" data-target="#addExpense" type="button" class="btn btn-warning">Aggiungi <i class="fa fa-plus"></i></button>
                    <br><br>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#expenseToDo">Previste</a></li>
                        <li><a data-toggle="tab" href="#expenseDone">Sostenute</a></li>
                        <li><a data-toggle="tab" href="#plotExpense">Statistiche</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--tab spese da sostenere-->
                        <div id="expenseToDo" class="tab-pane fade in active">
                            <!-- non sostenute -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-danger margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-ban fa-fw"></i> Insoluti</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="expiredExpense" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>                                
                                                            <th>Data pagamento</th>
                                                            <th>Data registrazione</th>
                                                            <th>Voce</th>
                                                            <th>Categoria</th>
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
                            <!-- da sostenere -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-yellow">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-arrow-left fa-fw"></i> Spese da sostenere</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="activeExpense" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>                                              
                                                            <th>Data pagamento</th>
                                                            <th>Data registrazione</th>
                                                            <th>Voce</th>
                                                            <th>Categoria</th>
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
                        </div>
                        <!--spese sostenute-->
                        <div id="expenseDone" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-green margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-arrow-left fa-fw"></i> Spese sostenute</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="payoffExpense" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>                                              
                                                            <th>Data registrazione</th>
                                                            <th>Data pagamento</th>
                                                            <th>Voce</th>
                                                            <th>Categoria</th>
                                                            <th>Importo €</th>
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
                        </div>
                        <!-- tab grafici spese -->
                        <div id="plotExpense" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-default margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Uscite negli anni</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafSpeseAnni"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-default margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Uscite nei mesi (anno corrente)</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafSpeseMesi"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-pie-chart fa-fw"></i> % di incidenza per categorie di uscita (anno corrente)</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafCategoria"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-pie-chart fa-fw"></i> % di incidenza per singola voce di uscita (anno corrente)</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafVoce"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-line-chart fa-fw"></i> % di incidenza per categorie negli anni</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="lineeCat"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"> <i class="fa fa-line-chart fa-fw"></i> % di incidenza per singola voce negli anni</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="lineeVoci"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
            
            <!-- Modal delete-->
            <div id="delete" class="modal fade" role="dialog">
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
            
            <!-- Modal conferma spesa-->
            <div id="done" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title">Sei sicuro?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Premere SI per confermare la spesa effettuata</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger">Sì</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal aggiunta spesa -->
            <div id="addExpense" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Aggiungi uscita</h4>
                        </div>
                        <div class="modal-body">
                            <form id="addForm" role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Categoria:</label>
                                    <div class="col-sm-5">
                                        <select id="categoria" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Nome:</label>
                                    <div class="col-sm-5">
                                        <select id="voce" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Data di registrazione:</label>
                                    <div class="col-sm-5">
                                        <input id="dataR" type="date" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Data di pagamento:</label>
                                    <div class="col-sm-5">
                                        <input id="dataP" type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Importo:</label>
                                    <div class="col-sm-5">
                                        <input id="importo" type="number" min="0.01" step="0.01" class="form-control">
                                    </div>
                                </div>
                                <hr/>
                                <h4>Detrazione importo</h4>
                                <div id="detrazioni">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-warning">Aggiungi <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="alert alert-danger hide">

                            </div>
                      </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Aggiungi</button>
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
    <script type="text/javascript" src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?=$config['js']?>bootstrap.min.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script type="text/javascript" src="<?=$config['js']?>metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="<?=$config['js']?>Chart.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>Expense/chartsJS.js"></script>        
    <script type="text/javascript" src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script type="text/javascript" src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>Expense/expenseJS.js"></script>

</body>

</html>