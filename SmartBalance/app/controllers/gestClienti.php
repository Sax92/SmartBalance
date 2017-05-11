<?php 
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class GestClienti extends Controller{
    //controller gestione clienti
    public function index(){
        $this->view('gestClienti/clientiView');
    
    }
   
    //funzione aggiungi cliente
    public function aggCliente(){
        $db=new Db();
        $result = $db->qAggCliente($_POST['codCliente'], $_POST['rsociale'],$_POST['citta'],$_POST['indirizzo'],$_POST['provincia'],$_POST['comune'],$_POST['cap'],$_POST['telefono'],$_POST['piva'],$_POST['cf']);
        if($result!=false){
            echo 'success';
        }else{
            echo 'errorData';
        }
    }
    
//funzione modifica cliente
    public function modCliente(){
        $db=new Db();
        $result = $db->qModCliente($_POST['idC'], $_POST['codCliente'], $_POST['rsociale'],$_POST['citta'],$_POST['indirizzo'],$_POST['provincia'],$_POST['comune'],$_POST['cap'],$_POST['telefono'],$_POST['piva'],$_POST['cf']);
        if($result!=false){
            echo 'success';
        }else{
            echo 'errorData';
        }
    }
    
    //funzione elimina cliente
    public function eliminaC(){
        $db=new Db();
        $result = $db->qEliminaC($_POST['idCliente']);
        if($result!=false){
            echo 'eliminatoOK';
        }else{
            echo 'errorData';
        }

    }
    
    //tabella entrate in arrivo
	public function getClienti(){
	  // DB table to use 
      $table = 'clienti';
      $sJoin = '';
      $where = "";
      
      // Table's primary key
      $primaryKey = 'idCliente';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'codCliente', 'dt' => 0 ),
        array( 'db' => 'ragSociale', 'dt' => 1 ),
		array( 'db' => 'citta', 'dt' => 2),
        array( 'db' => 'indirizzo', 'dt' => 3),
        array( 'db' => 'provincia', 'dt' => 4),
        array( 'db' => 'idCliente', 'dt' => 5)  
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
     public function inviaID(){
        $_SESSION['idC']=$_POST['idCliente'];
        echo 'success';
    }
    
    public function schedaCliente(){
        $this->view('gestClienti/clienteView');
    }
    
    public function getDatiCliente(){
        $db = new Db();
        $result = $db->qGetDatiCliente($_SESSION['idC']);
        if ($result != false){
            echo '<h3>'. $result['ragSociale'] .'</h3>
                    <p>'. $result['indirizzo'] .' '. $result['CAP'] .' '. $result['citta'] .' '. $result['provincia'] .'</p>';
            if (isset($result['telefono'])){
                echo '<p> Tel. '. $result['telefono'] .'</p>';
            }
            if (isset($result['pIva'])){
                echo '<p> P. IVA '. $result['pIva'] .'</p>';
            }
            if (isset($result['CF'])){
                echo '<p> CF '. $result['CF'] .'</p>';
            }
        }
    }
    
    //grafici entrate cliente negli anni
    public function chartClienteAnni(){
        $db = new Db();
        $result = $db->qChartClienteAnni($_SESSION['idC']);
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafici entrate cliente nei mesi
    public function chartClienteMesi(){
        $db = new Db();
        $result = $db->qChartClienteMesi($_SESSION['idC']);
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //dato incidenza entrate su totale anno corrente cliente
    public function incidenzaTotale(){
        $db = new Db();
        $result = $db->qIncidenzaTotale($_SESSION['idC']);
        if (($result != false) or ($result==0)){
            echo $result;
        }else{
            echo 'no';
        }
    }
    
    public function loadCliente(){
        $db = new Db();
        $result = $db->qLoadCliente($_POST['idC']);
        if ($result != false){
            echo json_encode($result);
        }
    }
    
    
    
    
    
    
    //fine controller
}