<?php 
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class Expense extends Controller{
    //controller uscite
    public function index(){
        $this->view('expense/expenseView');
    }
    
    //tabella tutte spese da sostenere
	public function getActiveExpense(){
	  // DB table to use 
      $table = 'uscite';
      $sJoin = '';
      $where = "dataPagamento > '". date('Y-m-d') ."' and fatta=0";
      
      // Table's primary key
      $primaryKey = 'idUscita';
      
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
        array( 'db' => 'categoria', 'dt' => 3),
		array(
        'db'        => 'importo',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idUscita', 'dt' => 5)  
        
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
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
    
    //recupero nomi spesa in base a categoria
    public function getExpenseName(){
        $db = new Db();
        $result = $db->qGetExpenseName($_POST['categoria']);
        if ($result!=false){
            echo '<option value="">Seleziona</option>';
            foreach($result as $nome){
                echo '<option value="'. $nome['nome'] .'">'. $nome['nome'] .'</option>';
            }
        }else{
           echo '<option value="">Nessuna voce presente</option>'; 
        }  
    }
    
    //aggiunta spesa
    public function addExpense(){
        $today = date('Y-m-d');
        if ($today > $_POST['dataP']){
            echo 'errorData';
        }else{
            $db = new Db();
            $result = $db->qAddExpense($_POST['voce'], $_POST['categoria'], $_POST['dataR'], $_POST['dataP'], $_POST['importo'],json_decode($_POST['detrazioni']));
            if ($result!=false){
                echo 'success';
            }
        } 
    }
        
    //delete spesa sostenuta
    public function deleteExpense(){
        $db = new Db();
        $result = $db->qDeleteExpense($_POST['idUscita']);
        if ($result!=false){
            echo 'delete';
        }  
    }
    
    //tabella tutte spese sostenute
	public function getExpense(){
	  // DB table to use
      $table = 'uscite';
      $sJoin = '';
      $where = "dataPagamento <= '". date('Y-m-d') ."' and fatta=1";
      
      // Table's primary key
      $primaryKey = 'idUscita';
      
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
        array( 'db' => 'categoria', 'dt' => 3),
		array(
        'db'        => 'importo',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idUscita', 'dt' => 5)  
        
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //tabella tutte spese NON sostenute
	public function getExpiredExpense(){
	  // DB table to use
      $table = 'uscite';
      $sJoin = '';
      $where = "dataPagamento <= '". date('Y-m-d') ."' and fatta=0";
      
      // Table's primary key
      $primaryKey = 'idUscita';
      
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
        array( 'db' => 'categoria', 'dt' => 3),
		array(
        'db'        => 'importo',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            setlocale(LC_MONETARY, 'it_IT');
            //return money_format('%.2n', $d);
			$fmt = new NumberFormatter( 'it_IT', NumberFormatter::CURRENCY );
			return $fmt->formatCurrency($d, "EUR");
          }
    	),
        array( 'db' => 'idUscita', 'dt' => 5)  
        
      );
 
      require( '../app/core/ssp.class.php' );
      
      echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $sJoin, $where )
      );
	}
    
    //conferma spesa sostenuta
    public function confirmExpense(){
        $db = new Db();
        $result = $db->qConfirmExpense($_POST['idUscita'],1);
        if ($result!=false){
            echo 'confirm';
        }  
    }
    
    //grafici spese anni
    public function chartExpenseYear(){
        $db = new Db();
        $result = $db->qChartExpenseYear();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafici spese mesi
    public function chartExpenseMonth(){
        $db = new Db();
        $result = $db->qChartExpenseMonth();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafici spese categoria
    public function chartExpenseCategory(){
        $db = new Db();
        $result = $db->qChartExpenseCategory();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafici spese voci
    public function chartExpenseName(){
        $db = new Db();
        $result = $db->qChartExpenseName();
        if ($result != false){
            echo json_encode($result);
        }else{
            echo 'no';
        }
    }
    
    //grafico spese negli anni categoria
    public function chartLineExpenseCat(){
        $db = new Db();
        $result = $db->qChartLineExpenseCat();
        if ($result != false){
            echo json_encode($result);
        }
    }
    
        //grafico spese negli anni categoria
    public function chartLineExpenseVoce(){
        $db = new Db();
        $result = $db->qChartLineExpenseVoce();
        if ($result != false){
            echo json_encode($result);
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
    
}