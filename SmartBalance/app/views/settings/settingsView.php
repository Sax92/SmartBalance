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
                    <h1 class="page-header">Impostazioni</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bars fa-fw"></i> Categorie di uscita</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="expenseCategory" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>                                
                                            <th>Categoria</th>
                                            <th>Colore</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-warning" id="aggiungiC" data-toggle="modal" data-target="#addCategory" type="button">Aggiungi <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bars fa-fw"></i> Voci di uscita</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="expenseVoci" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>        
                                            <th>Voce</th>
                                            <th>Colore</th>
                                            <th>Categoria</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-warning" id="aggiungiV" data-toggle="modal" data-target="#addVoce" type="button">Aggiungi <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            
            <!-- row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bars fa-fw"></i> Detrazioni</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="detrazioniNome" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>        
                                            <th>Nome</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-warning" id="aggiungiD" data-toggle="modal" data-target="#addDet" type="button">Aggiungi <i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-database fa-fw"></i> Impostazione backup</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <a href="backupDB" class="btn btn-warning">Esegui backup</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            
            <!-- Modal delete-->
            <div id="deleteC" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Sei sicuro?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Premere SI per eliminare la categoria definitivamente</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger">Sì</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal delete-->
            <div id="deleteV" class="modal fade" role="dialog">
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
            
            <!-- Modal errore delete voce -->
            <div id="deleteVError" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Errore</h4>
                        </div>
                        <div class="modal-body">
                            <p>La voce è collegata almeno ad una spesa nel sistema</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal errore delete categoria -->
            <div id="deleteCError" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Errore</h4>
                        </div>
                        <div class="modal-body">
                            <p>La categoria è collegata almeno ad una spesa nel sistema, oppure esiste ancora almeno una voce appartenente a questa categoria</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal delete-->
            <div id="deleteD" class="modal fade" role="dialog">
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
            
            <!-- Modal errore delete detrazione -->
            <div id="deleteDError" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Errore</h4>
                        </div>
                        <div class="modal-body">
                            <p>Non è possibile eliminare una detrazione in uso nel sistema.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal aggiunta categoria -->
            <div id="addCategory" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Aggiungi categoria</h4>
                        </div>
                        <div class="modal-body">
                            <form id="addFormC" role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Nome categoria:</label>
                                    <div class="col-sm-5 input-group">
                                        <input id="categoriaAdd" type="text" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Colore:</label>
                                    <div id="colorCategory" class="col-sm-5 input-group colorpicker-component">
                                        <input type="text" class="form-control" value="#00AABB">
                                        <span class="input-group-addon"><i></i></span>
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
            
            <!-- Modal aggiunta categoria -->
            <div id="addDet" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Aggiungi detrazione</h4>
                        </div>
                        <div class="modal-body">
                            <form id="addFormD" role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Nome:</label>
                                    <div class="col-sm-5 input-group">
                                        <input id="detAdd" type="text" class="form-control" value="">
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
            
            <!-- Modal aggiunta voce  -->
            <div id="addVoce" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header modal-header-primary">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Aggiungi voce</h4>
                        </div>
                        <div class="modal-body">
                            <form id="addFormV" role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Nome voce:</label>
                                    <div class="col-sm-5 input-group">
                                        <input id="voceAdd" type="text" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Categoria:</label>
                                    <div class="col-sm-5 input-group">
                                        <select id="categoriaV" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4">Colore:</label>
                                    <div id="colorVoce" class="col-sm-5 input-group colorpicker-component">
                                        <input type="text" class="form-control" value="#00AABB">
                                        <span class="input-group-addon"><i></i></span>
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
    <script src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$config['js']?>metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script type="text/javascript" src="<?=$config['js']?>bootstrap-colorpicker.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>Settings/settingsJS.js"></script>


</body>

</html>