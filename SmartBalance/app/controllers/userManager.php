<?php 
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class UserManager extends Controller{
    
    //funzione converti data
    function data_database($data){
       // Creo una array dividendo la data sulla base del trattino
        $array = explode("/", $data); 
       // Riorganizzo gli elementi invertendo l'ordine della data rispetto a quella inserita nel form
        $data_db = $array[2]."-".$array[1]."-".$array[0]; 
       // Restituisco il valore della data in formato italiano
       return $data_db; 
    }
	
	
	public function index(){
		$this->view('userManager/main');
	}
	
	//numero spese odierne
	public function getTodayExpense(){
		$db=new Db();
		$result=$db->qGetTodayExpense();
		if($result!=false){
			echo $result[0]['num'];
		}else{
			return false;
		}
	}
    
    //numero entrate odierne
	public function getTodayEntry(){
		$db=new Db();
		$result=$db->qGetTodayEntry();
		if($result!=false){
			echo $result[0]['num'];
		}else{
			return false;
		}
	}
    
    //numero entrate non ricevute
	public function getEntryNotReiceved(){
		$db=new Db();
		$result=$db->qGetEntryNotReiceved();
		if($result!=false){
			echo $result[0]['num'];
		}else{
			return false;
		}
	}
    
    //numero insoluti
	public function getInsoluti(){
		$db=new Db();
		$result=$db->qGetInsoluti();
		if($result!=false){
			echo $result[0]['num'];
		}else{
			return false;
		}
	}
	
    //totale spese
	public function getTotExpense(){
		$db=new Db();
		$result=$db->qGetTotExpense();
		if($result!=false){
            if ($result[0]['tot']>0){
                $_SESSION['usciteTot'] = $result[0]['tot'];
                setlocale(LC_MONETARY, 'it_IT'); 
                //echo money_format('%.2n', $result[0]['tot']);
				$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
				echo $fmt->formatCurrency($result[0]['tot'], "EUR");
            }else{
                setlocale(LC_MONETARY, 'it_IT'); 
                $_SESSION['usciteTot'] = 0;
                //echo money_format('%.2n', 0);
				$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
				echo $fmt->formatCurrency(0, "EUR");
            }
		}else{
			return false;
		}
	}
    
    //totale entrate
	public function getTotEntry(){
		$db=new Db();
		$result=$db->qGetTotEntry();
		if($result!=false){
            if ($result[0]['tot']>0){
                setlocale(LC_MONETARY, 'it_IT'); 
                $_SESSION['entrateTot'] = $result[0]['tot'];
                //echo money_format('%.2n', $result[0]['tot']);
				$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
				echo $fmt->formatCurrency($result[0]['tot'], "EUR");
            }else{
                setlocale(LC_MONETARY, 'it_IT'); 
                $_SESSION['entrateTot'] = 0;
                //echo money_format('%.2n', 0);
				$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
				echo $fmt->formatCurrency(0, "EUR");
            }
		}else{
			return false;
		}
	}
    
    //saldo entrate/uscite
    public function getSaldo(){
        $saldo = $_SESSION['entrateTot'] - $_SESSION['usciteTot'];
        if ($saldo>0){
            $saldo='+ '.$saldo;
        }
        
        setlocale(LC_MONETARY, 'it_IT');    
        //echo money_format('%.2n', $saldo);
		$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
		echo $fmt->formatCurrency($saldo, "EUR");
    }
    
    //grafico confronto entrate/uscite anno corrente
    public function chartCompare(){
        $db = new Db();
        $result = $db->qChartCompare();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafico confronto negli anni
    public function chartCompareYears(){
        $db = new Db();
        $result = $db->qChartCompareYears();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
//tabella detrazioni entrate
	public function getDetEntrate(){
	  // DB table to use 
      $table = 'detrazioni';
      $sJoin = '';
      $where = "tipo = 'entrata'";
      
      // Table's primary key
      $primaryKey = 'idDetrazione';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'nome', 'dt' => 0 ),
        array(
        'db'        => 'data',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array(
        'db'        => 'importo',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idDetrazione', 'dt' => 3 )  
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
//tabella detrazioni uscite
	public function getDetUscite(){
	  // DB table to use 
      $table = 'detrazioni';
      $sJoin = '';
      $where = "tipo = 'uscita'";
      
      // Table's primary key
      $primaryKey = 'idDetrazione';
      
      // Array of database columns which should be read and sent back to DataTables.
      // The db parameter represents the column name in the database, while the dt
      // parameter represents the DataTables column identifier. In this case simple
      // indexes
      $columns = array(
        array( 'db' => 'nome', 'dt' => 0 ),
        array(
        'db'        => 'data',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            return date( 'd/m/Y', strtotime($d));
          }
    	),
        array(
        'db'        => 'importo',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idDetrazione', 'dt' => 3 )  
    );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
//delete detEntrata
    public function deleteDetE(){
        $db = new Db();
        $result = $db->qDeleteDetE($_POST['idDetrazione']);
        if ($result!=false){
            echo json_encode('delete');
        }  
    }
    
//delete detEntrata
    public function deleteDetU(){
        $db = new Db();
        $result = $db->qDeleteDetU($_POST['idDetrazione']);
        if ($result!=false){
            echo json_encode('delete');
        }  
    }
    
	
}

?> 