<?php 
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class Entry extends Controller{
    //controller entrate
    public function index(){
        $this->view('entry/entryView');
    }
    
    //aggiungi entrata prevista
    public function aggEntrataP(){
     //   $today = date('Y-m-d');
      //  if(($today > $_POST['dRegistrazione']) or ($today > $_POST['dPagamento'])){
          //  echo 'errorData';
      //  }else{
            $db=new Db();
            $result=$db->qAggEntrataP($_POST['nome'],$_POST['dRegistrazione'], $_POST['dPagamento'], $_POST['importo'], $_POST['idCliente'], json_decode($_POST['detrazioni']));
            if($result!=false){
                echo 'success';
            }
      //  }
    }
    
    //delete entrata
    public function deleteEntry(){
        $db = new Db();
        $result = $db->qDeleteEntry($_POST['idEntrata']);
        if ($result!=false){
            echo 'delete';
        }  
    }
    
    public function searchC(){
       $db=new Db();
        $result = $db->qSearchC($_POST['nominativo']);
        if($result != false){
            foreach($result as $res){
                echo '<option value="'.$res['idCliente'].'">'.$res['ragSociale'].'</option>'; 
            }
        }else{
            echo "false";
        }
        
    }
    
      //tabella entrate in arrivo
	public function getActiveEntrate(){
	  // DB table to use 
      $table = 'entrate';
      $sJoin = '';
      $where = "dataPagamento > '". date('Y-m-d') ."' and fatto = 0";
      
      // Table's primary key
      $primaryKey = 'idEntrata';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array(
        'db'        => 'dataPagamento',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array(
        'db'        => 'dataFattura',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array( 'db' => 'voce', 'dt' => 2 ),
		array(
        'db'        => 'importo',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idEntrata', 'dt' => 4)    
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //tabella entrate insolute
    public function getActiveEntrateIn(){
	  // DB table to use 
      $table = 'entrate';
      $sJoin = '';
      $where = "dataPagamento <= '". date('Y-m-d') ."' and fatto = 0";
      
      // Table's primary key
      $primaryKey = 'idEntrata';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array(
        'db'        => 'dataPagamento',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array(
        'db'        => 'dataFattura',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array( 'db' => 'voce', 'dt' => 2 ),
		array(
        'db'        => 'importo',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idEntrata', 'dt' => 4)  
          
        
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
        //tabella entrate arrivate
	public function getActiveEntrateArr(){
	  // DB table to use 
      $table = 'entrate';
      $sJoin = '';
      $where =  "dataPagamento <= '". date('Y-m-d') ."' and fatto = 1";
      
      // Table's primary key
      $primaryKey = 'idEntrata';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array(
        'db'        => 'dataPagamento',
        'dt'        => 0,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array(
        'db'        => 'dataFattura',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),  
        array( 'db' => 'voce', 'dt' => 2 ),
		array(
        'db'        => 'importo',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	)     
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //funzione per modal pagato
   public function pagato(){
       $db=new Db(); 
       if($db->qSetPagato($_POST['idEntrata'])){
           echo "pagatoOK";
       }   
   }
    
//recupero spese per detrazione importo
    public function getAllVociSpesa(){
        $db=new Db();
        $result = $db->qGetAllVociSpesa();
        if ($result!=false){
            echo '<option value="">Seleziona</option>';
            foreach($result as $res){
                echo '<option value="'. $res['nomeDet'] .'">'. $res['nomeDet'] .'</option>';
            }
        }
    }
    
        //grafici spese anni
    public function chartEntryYear(){
        $db = new Db();
        $result = $db->qChartEntryYear();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafici spese mesi
    public function chartEntryMonth(){
        $db = new Db();
        $result = $db->qChartEntryMonth();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
  
//fine controller
}

