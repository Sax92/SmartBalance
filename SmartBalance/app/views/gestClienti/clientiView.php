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
                    <h1 class="page-header">Gestione clienti</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- bottone aggiungi -->
            
            <div class="row">
                <div class="col-lg-12">
                     <button id="aggiungi" type="button" class="btn btn-warning" data-toggle="modal" data-target="#aggModal">Aggiungi <i class="fa fa-plus"></i></button>
                </div>    
            </div>    
                
              <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-green margin-top">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-users fa-fw"></i>Clienti</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="activeClienti" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Cod. cliente</th>
                                            <th>Ragione sociale</th>
                                            <th>Città</th>
                                            <th>Indirizzo</th>
                                            <th>Provincia</th>
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
            <!--tabella clienti-->
            
            
        </div>
        <!-- /.page-wrapper -->
        <?php include 'Footer.php';?>
        
    </div>
         <!-- /.wrapper --> 
    
     <!-- modal bottone aggiungi -->
        <div id="aggModal" class=" modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Aggiungi cliente</h4>
                    </div>

                    <div class="modal-body">
                        <form id="addForm" role="form" class="form-horizontal">
                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Cod. Cliente:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="codCliente" placeholder="codice">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Ragione sociale:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="rsociale" placeholder="nominativo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Città:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="citta">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Indirizzo:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="indirizzo" placeholder="es. via o piazza">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Provincia:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="provincia">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Comune:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="comune">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">CAP:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="cap">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Telefono:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="telefono">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">P.iva:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="piva">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">CF:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control text-uppercase" id="cf">
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
            <!-- /fine modal bottone-->
            </div> 
    
         <!-- modal bottone modifica -->
        <div id="editModal" class=" modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modifica cliente</h4>
                    </div>

                    <div class="modal-body">
                        <form id="addForm" role="form" class="form-horizontal">
                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Cod. Cliente:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="codClienteM" placeholder="codice">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Ragione sociale:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="rsocialeM" placeholder="nominativo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Città:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="cittaM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Indirizzo:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="indirizzoM" placeholder="es. via o piazza">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Provincia:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="provinciaM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Comune:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="comuneM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">CAP:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="capM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">Telefono:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="telefonoM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">P.iva:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="pivaM">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="usr" class="control-label col-sm-4">CF:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control text-uppercase" id="cfM">
                                </div>
                            </div>
                            </form>
                            <div class="alert alert-danger hide"></div>
                        </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" >Aggiorna</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                            </div>

                        </div>
                    </div>
            <!-- /fine modal bottone modifica-->
            </div>
    
            <!-- Modal elimina cliente-->
            <div id="modalElimina" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div id="confirm" class="modal-header modal-header-danger ">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Rimuovi Cliente</h4>
                        </div>
                        <div class="modal-body">
                            <div id="question" class="modal-body">
                                <p>Premere SI per rimuovere il cliente selezionato!</p>
                                <p><strong>Attenzione:</strong> rimuovendo il cliente, eliminerai dal sistema tutte le entrate associate a questo cliente!</p>

                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"  >Sì</button>
                            <button id="null" type="button" class="btn btn-default" data-dismiss="modal" >Annulla</button>

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
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>GestClienti/clientiJS.js"></script>


</body>

</html>