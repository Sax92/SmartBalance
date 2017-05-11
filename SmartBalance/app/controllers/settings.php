<?php 
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class Settings extends Controller{
    public function index(){
        $this->view('settings/settingsView');
    }
    
    //tabella categorie
	public function getCategory(){
	  // DB table to use 
      $table = 'tipouscita';
      $sJoin = '';
      $where = "";
      
      // Table's primary key
      $primaryKey = 'categoria';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'categoria', 'dt' => 0 ),
        array( 'db' => 'colore', 'dt' => 1),  
        
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //tabella voci
	public function getVoci(){
	  // DB table to use 
      $table = 'nomeuscita';
      $sJoin = '';
      $where = "";
      
      // Table's primary key
      $primaryKey = 'nome';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'nome', 'dt' => 0 ),
        array( 'db' => 'colore', 'dt' => 1),
        array( 'db' => 'categoria', 'dt' => 2)
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
//tabella voci det
	public function getDet(){
	  // DB table to use 
      $table = 'tipo_detrazioni';
      $sJoin = '';
      $where = "";
      
      // Table's primary key
      $primaryKey = 'nomeDet';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'nomeDet', 'dt' => 0 )
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //elimina categoria
    public function deleteCategory(){
        $db = new Db();
        $result = $db->qDeleteCategory($_POST['categoria']);
        if ($result!=false){
            echo 'delete';
        }  
    }
    
    //elimina voce
    public function deleteVoce(){
        $db = new Db();
        $result = $db->qDeleteVoce($_POST['voce']);
        if ($result!=false){
        echo 'delete';
        }  
    }
    
    //aggiunta categoria
    public function addCategory(){
        $db = new Db();
        $result = $db->qAddCategory($_POST['categoria'], $_POST['coloreC']);
        if ($result!=false){
            echo 'success';
        }else{
            echo 'errorData';
        }  
    }
    
    //aggiunta voce
    public function addVoce(){
        $db = new Db();
        $result = $db->qAddVoce($_POST['categoria'], $_POST['coloreV'], $_POST['voce']);
        if ($result!=false){
            echo 'success';
        }else{
            echo 'errorData';
        }  
    }
    
    //elimina voce det
    public function deleteDetrazione(){
        $db = new Db();
        $result = $db->qDeleteDetrazione($_POST['nome']);
        if ($result!=false){
        echo 'delete';
        }  
    }
    
    //aggiunta voce det
    public function addDet(){
        $db = new Db();
        $result = $db->qAddDet($_POST['nomeDet']);
        if ($result!=false){
            echo 'success';
        }else{
            echo 'errorData';
        }  
    }
    
    //recupero categorie spesa
    public function getExpenseCategory(){
        $db = new Db();
        $result = $db->qGetExpenseCategory();
        if ($result!=false){
            echo '<option value="">Seleziona</option>';
            foreach($result as $category){
                echo '<option value="'. $category['categoria'] .'">'. $category['categoria'] .'</option>';
            }
        }else{
           echo '<option value="">Nessuna voce presente</option>'; 
        }  
    }
    
    public function backupDB(){
        $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = 'silva16';
        $dbname = 'managerdb';
        //$backup_file = '/opt/lampp/htdocs/Webprogramming/MVC_Camilla/public/backup/'.$dbname.'-'. date("Y-m-d-H-i-s") . '.sql';
        //$command = "/opt/lampp/bin/mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "".$dbname." | gzip > $backup_file";
		$backup_file = '../backup/'. $dbname .'-'. date('Y-m-d-H-i-s') . '.sql';
        $command = 'C:/xampp/mysql/bin/mysqldump --opt -h '.$dbhost.' -u '.$dbuser.' '.$dbname.' > '.$backup_file;
        system($command, $ret);
        if ($ret==0){
			echo 'success';
		}
    }
    
}