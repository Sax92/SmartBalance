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
                    <h1 class="page-header">Scheda cliente</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- bottone aggiungi -->
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="well well-sm"></div>     
                </div>
                <div class="col-sm-5">
                    <h4>Incidenza sul totale entrate (anno corrente)</h4>
                    <h1 id="incidenza"></h1>
                </div>
            </div>
            <!-- ./row-->
            
            <div class="row">
                <h4>Statistiche</h4>
                <hr/>
                <div class="col-lg-6">
                    <div class="panel panel-default margin-top">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Entrate procurate negli anni</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <canvas id="gClienteAnni"></canvas>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default margin-top">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart fa-fw"></i> Entrate procurate nei mesi (anno corrente)</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <canvas id="gClienteMesi"></canvas>
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
            <!-- ./row -->
            
         </div>
         <!-- /.page wrapper --> 
        <?php include 'Footer.php';?>
    </div>
        <!-- /.rapper -->
       
    <!-- jQuery -->
    <script src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>
    
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=$config['js']?>metisMenu.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="<?=$config['js']?>Chart.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>GestClienti/chartsClienteJS.js"></script> 
    <script src="<?=$config['js']?>sb-admin-2.js"></script>
    
    <!--Custom js-->
    <script src="<?=$config['js']?>jquery.dataTables.min.js"></script>
    <script src="<?=$config['js']?>dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$config['js']?>GestClienti/clienteJS.js"></script>


</body>

</html>