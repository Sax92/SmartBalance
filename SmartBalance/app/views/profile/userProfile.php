<?php
function data_database($data){
    if ($data!='-'){
        // Creo una array dividendo la data sulla base del trattino
       $array = explode("-", $data); 

       // Riorganizzo gli elementi invertendo l'ordine della data rispetto a quella inserita nel form
       $data_db = $array[2]."/".$array[1]."/".$array[0]; 

       // Restituisco il valore della data in formato italiano
       return $data_db; 
    }else{
        return $data;
    }
   
}

include 'Header.php';
?>

<body>		
        
      <div id="wrapper">      
            <?php $menu=new Menu();
		          $menu->printMenu(); ?>
        <div id="page-wrapper">          

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Profilo</h1>
                    </div>
                </div>
                <!-- /.row -->
                
                <!--FORM PROFILO-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?=$_SESSION['user']['nome']?> <?=$_SESSION['user']['cognome']?></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <img class="img-responsive input"src="<?php
                                               // echo getcwd();
                                                if(file_exists('img/usersPhoto/'.$_SESSION['user']['idUser'])){
                                                    echo $config['img'].'usersPhoto/'.$_SESSION['user']['idUser'];
                                                }else{
                                                    echo $config['img'].'avatar.png';
                                                }
                                                ?>"/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form enctype="multipart/form-data" action="uploadPhoto" method="post">
                                                    <!--<input type="hidden" name="MAX_FILE_SIZE" value="30000">-->
                                                    <input id="upload" name="userPhoto" class="btn btn-sm btn-info input hide" type="file">
                                                    <button id="photo" type="button" class="btn btn-sm btn-info">Aggiorna foto <i class="fa fa-camera"></i></button>
                                                    <button id="confirm" type="submit" class="btn btn-sm btn-success hide">Carica <i class="fa fa-camera"></i></button>                                                
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        
                                        <table id="profileUser" class="table table-hover">
                                                <tr>
                                                    <td>Nome</td>
                                                    <td><?=$_SESSION['user']['nome']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Cognome</td>
                                                    <td><?=$_SESSION['user']['cognome']?></td>
                                                </tr>
                                                <tr>
                                                    <td>E-mail</td>
                                                    <td><?=$_SESSION['user']['email']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Indirizzo</td>
                                                    <td><?=$_SESSION['user']['indirizzo']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Città</td>
                                                    <td><?=$_SESSION['user']['citta']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Comune</td>
                                                    <td><?=$_SESSION['user']['comune']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Provincia</td>
                                                    <td><?=$_SESSION['user']['provincia']?></td>
                                                </tr>
                                                <tr>
                                                    <td>CAP</td>
                                                    <td><?=$_SESSION['user']['cap']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Telefono</td>
                                                    <td><?=$_SESSION['user']['telefono']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Cellulare</td>
                                                    <td><?=$_SESSION['user']['cellulare']?></td>
                                                </tr>
                                                <tr>
                                                    <td>P. IVA</td>
                                                    <td><?=$_SESSION['user']['pIva']?></td>
                                                </tr>
                                                <tr>
                                                    <td>CF</td>
                                                    <td><?=$_SESSION['user']['cf']?></td>
                                                </tr>
                                        </table>
                                        
                                        <!--EDIT USER--->
                                        <div class="form-group hide" id="editUser">
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label class="" for="nome">Nome</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="nomeU" value="<?=$_SESSION['user']['nome']?>" type="text" required>
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Cognome</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="cognomeU" value="<?=$_SESSION['user']['cognome']?>" type="text" required>
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">E-mail</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="emailU" value="<?=$_SESSION['user']['email']?>" type="email" required>
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Indirizzo</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="indirizzoU" value="<?=$_SESSION['user']['indirizzo']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Citta</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="cittaU" value="<?=$_SESSION['user']['citta']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Comune</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="comuneU" value="<?=$_SESSION['user']['comune']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Provincia</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="provinciaU" value="<?=$_SESSION['user']['provincia']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">CAP</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="capU" value="<?=$_SESSION['user']['cap']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Telefono</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="telefonoU" value="<?=$_SESSION['user']['telefono']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">Cellulare</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control" id="cellulareU" value="<?=$_SESSION['user']['cellulare']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">P. IVA</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control text-uppercase" id="pIvaU" value="<?=$_SESSION['user']['pIva']?>" type="text">
                                                </div>
                                            </div>
                                            <div class="row input">
                                                <div class="col-lg-2">
                                                <label for="nome">CF</label>
                                                </div>
                                                <div class="col-lg-5">
                                                    <input class="form-control text-uppercase" id="cfU" value="<?=$_SESSION['user']['cf']?>" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <!--ALERT-->
                                        <div id="userUpdated" class="alert alert-success hide">
                                            <strong>Profilo aggiornato correttamente!</strong>
                                            <img class="img-responsive" src="<?=$config['img']?>loading.gif" />
                                        </div>
                                        <div id="userErrorUpdate" class="alert alert-danger hide">
                                            <strong>Errore aggiornamento profilo.</strong>
                                        </div>
                                        <!-- ./ ALERT -->
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                 <button id="edit" type="button" class="btn btn-sm btn-warning">Modifica dati <i class="fa fa-edit"></i></button>
                                 <button id="update" type="button" class="btn btn-sm btn-success hide">Aggiorna dati <i class="fa fa-check-square-o"></i></button>
                            </div>
                        </div>
                    </div>  
                </div>
                <!-- /.row -->
                
                <!-- Modal -->
                    <div id="errorModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header-danger">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-warning"></i> Errore aggiornamento dati!</h4>
                          </div>
                          <div class="modal-body">
                            <p>Controlla di aver inserito correttamente nome, cognome ed e-mail!</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-info" data-dismiss="modal">Chiudi</button>
                          </div>
                        </div>

                      </div>
                    </div>
                <!-- ./Modal -->    

        </div>
        <!-- /#page-wrapper -->
        <?php include 'Footer.php';?>
    </div>
    <!-- /#wrapper -->
    
    <!-- jQuery -->
    <script src="<?=$config['js']?>jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=$config['js']?>bootstrap.min.js"></script>
    
    <!--Custom js-->
    <script type="text/javascript" src="<?=$config['js']?>Profile/userProfile.js"></script>

</body>

</html>