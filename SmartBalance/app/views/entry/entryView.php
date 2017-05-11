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
                    <h1 class="page-header">Gestione entrate</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!--bottone aggiungi-->
            <div class="row">
                <div class="col-lg-12">
                    <button id="aggiungi" type="button" class="btn btn-warning" data-toggle="modal" data-target="#aggModal">Aggiungi <i class="fa fa-plus"></i></button> 
                </div>
            </div>
            
            </br>
            </br>
            <!--./bottone aggiungi-->
            
            <!--tab per selezione tabella-->
           <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#inArrivo">Previste</a></li>
                        <li><a data-toggle="tab" href="#arrivate">Avvenute</a></li>
                        <li><a data-toggle="tab" href="#statistiche">Statistiche</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--tabella previste-->
                        <div id="inArrivo" class="tab-pane fade in active">
                            <!--seconda tabella scadute-->
                            <div class="row">
                                <div class="col-lg-12">
                                
                                    <div class="panel panel-danger margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-ban fa-fw"></i> Entrate non ricevute</h3>
                                        </div>
                                        <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="activeEntrateIn" class="table table-hover table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Data pagamento</th>
                                                        <th>Data registrazione</th>
                                                        <th>Descrizione</th>
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
                        
                            
                        <!--prima tabella-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-yellow margin-top">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-arrow-right fa-fw"></i> Entrate previste</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="activeEntrate" class="table table-hover table-striped table-bordered">
                                                <thead>
                                                    <tr>           
                                                        <th>Data pagamento</th>
                                                        <th>Data registrazione</th>
                                                        <th>Descrizione</th>
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
                            
                          
                            <!--tabella entrate avvenute-->
                        <div id="arrivate" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-green margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-arrow-right fa-fw"></i> Entrate avvenute</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="activeEntrateArr" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>                   
                                                            <th>Data pagamento</th>
                                                            <th>Data registrazione</th>
                                                            <th>Descrizione</th>
                                                            <th>Importo €</th>
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
                        
                        <div id="statistiche" class="tab-pane fade">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-default margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Entrate negli anni</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafEntrateAnni"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-default margin-top">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Entrate nei mesi (anno corrente)</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <canvas id="grafEntrateMesi"></canvas>
                                                </div>
                                            </div>
                                        </div>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--/.tab per selezione tabella-->
                    </div>
                    <!--/.col per selezione tabella-->
                </div>
               <!--/.row per selezione tabella-->
            </div>

            <!--CONTENUTO PAGINA-->

        </div>
        <!-- /#page-wrapper -->

        <?php include 'Footer.php';?>

    </div>
    <!-- /#wrapper -->

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

    <!-- Modal pagato-->
    <div id="modalPagato" class="modal fade" role="dialog">
        <div class="modal-dialog">
    <!-- Modal content-->
            <div class="modal-content">
                <div id="confirm" class="modal-header modal-header-success ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Conferma pagamento</h4>
                </div>
                <div class="modal-body">
                    <div id="question" class="modal-body">
                        <p>Premere SI se il pagamento è avvenuto!</p>
                    
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Sì</button>
                    <button id="null" type="button" class="btn btn-default" data-dismiss="modal" >Annulla</button>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="aggModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ">Aggiungi entrata</h4>
                </div>

                <div class="modal-body">
                    <form id="addForm" role="form" class="form-horizontal">

                        <div class="form-group">
                            <label for="usr" class="control-label col-sm-4">Cerca:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="cerca" placeholder="es. nominativo cliente">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sel1" class="control-label col-sm-4">Selezione cliente:</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="idCliente"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="usr" class="control-label col-sm-4">Descrizione:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="nome">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="usr" class="control-label col-sm-4">Data registrazione:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" id="dRegistrazione">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="usr" class="control-label col-sm-4">Data di pagamento:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" id="dPagamento">
                            </div>    
                        </div>

                        <div class="form-group">
                            <label for="usr" class="control-label col-sm-4">Importo:</label>
                            <div class="col-sm-5">
                                <input type="number" min="0.01" step="0.01" class="form-control" id="importo">
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
                    <div class="alert alert-danger hide"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" >Aggiungi</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                </div>
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
    <script type="text/javascript" src="<?=$config['js']?>Chart.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>Entry/chartEJS.js"></script>
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>Entry/entryJS.js"></script>

</body>

</html>