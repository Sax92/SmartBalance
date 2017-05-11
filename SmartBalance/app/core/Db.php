<?php 

class Db{
    //funzione converti data
    function data_database($data){
       // Creo una array dividendo la data sulla base del trattino
        $array = explode("/", $data); 
       // Riorganizzo gli elementi invertendo l'ordine della data rispetto a quella inserita nel form
        $data_db = $array[2]."-".$array[1]."-".$array[0]; 
       // Restituisco il valore della data in formato italiano
       return $data_db; 
    }
	
	//connessione DB
	public function connect(){
		// collegamento al database con PDO
		$col = 'mysql:host=localhost;dbname=managerdb;charset=utf8';
			
		// blocco try per il lancio dell'istruzione
		try {
		// connessione tramite creazione di un oggetto PDO
		$db = new PDO($col , 'root', '');
		return $db;
		}
		// blocco catch per la gestione delle eccezioni
		catch(PDOException $e) {
		// notifica in caso di errorre
		echo 'Attenzione: '.$e->getMessage();
		}
	}
	
	//LOGIN
	public function qLogin($email,$password){
		$db = $this->connect();
		try{
			// preparazione della query 
			$sql = $db->prepare('SELECT * FROM user WHERE email = :email and password = :password');
			//binding dei parametri
			$sql->bindParam(':email',$email);
            if (strlen($password)>10){
                $sql->bindParam(':password', $password);
            }else{
                $sql->bindParam(':password',md5($password));
            }
			
			// esecuzione della query 
			$sql->execute();
			// creazione di un array dei risultati
			if ($row = $sql->rowCount()>0){
				$res = $sql->fetch();
				return $res;
			}
			else{
				return false;
			}	
		}catch(PDOException $ex){
			$ex->getMessage();
		}
		
		$db=null;
	}
    
    /***************************GESTIONE SPESE***********************************/
    
    //recupero categorie spese
    public function qGetExpenseCategory(){
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT categoria FROM tipouscita");
            if ($sql->execute()){
                while ($row = $sql->fetch()){
                    $result[]=$row;
                }
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //recupero nomi spese
    public function qGetExpenseName($categoria){
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT nome FROM nomeuscita WHERE categoria = :categoria");
            $sql->bindParam(':categoria',$categoria);
            if ($sql->execute()){
                while ($row = $sql->fetch()){
                    $result[]=$row;
                }
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //aggiunta spesa
    public function qAddExpense($voce, $categoria, $dataR, $dataP, $importo, $detrazioni){
        $db=$this->connect();
        try{
            //print_r($detrazioni);
            if ($detrazioni!=0){
                $detrTot=0;
                foreach($detrazioni as $det){
                    if (($det->voce!=null) or ($det->voce!='')){
                        $detrTot += $det->valore;
                       /* $sql = $db->prepare("SELECT categoria FROM nomeuscita WHERE nome = :nomeU");
                        $sql->bindParam(':nomeU', $det->voce);
                        if ($sql->execute()){
                            $res = $sql->fetch();*/
                            $sql = $db->prepare("INSERT INTO detrazioni (nome, tipo, data, importo)
                            VALUES (:voce, :tipo, :dataFattura, :importo)");
                            $sql->bindParam(':voce', $det->voce);
                            $e='uscita';
                            $sql->bindParam(':tipo', $e);
                            $sql->bindParam(':dataFattura', $dataR);
                            $sql->bindParam(':importo', $det->valore);
                            $sql->execute();
                       /* }else{
                            return false;
                        }  */   
                    }
                }
                $importo-=$detrTot;
                $sql = $db->prepare("INSERT INTO uscite (voce, categoria, dataFattura, importo, dataPagamento)
                                    VALUES (:voce, :categoria, :dataFattura, :importo, :dataPagamento)");
                $sql->bindParam(':voce', $voce);
                $sql->bindParam(':categoria', $categoria);
                $sql->bindParam(':dataFattura', $dataR);
                $sql->bindParam(':importo', $importo);
                $sql->bindParam(':dataPagamento', $dataP);
                if ($sql->execute()){
                    return true;
                }else{
                    return false;
                }
            }else{
                $sql = $db->prepare("INSERT INTO uscite (voce, categoria, dataFattura, importo, dataPagamento)
                                    VALUES (:voce, :categoria, :dataFattura, :importo, :dataPagamento)");
                $sql->bindParam(':voce', $voce);
                $sql->bindParam(':categoria', $categoria);
                $sql->bindParam(':dataFattura', $dataR);
                $sql->bindParam(':importo', $importo);
                $sql->bindParam(':dataPagamento', $dataP);
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //elimina spesa
    public function qDeleteExpense($idUscita){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM uscite WHERE idUscita = :idUscita");
            $sql->bindParam(':idUscita', $idUscita);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //elimina spesa
    public function qConfirmExpense($idUscita, $fatta){
        $db=$this->connect();
        try{
            $sql = $db->prepare("UPDATE uscite SET fatta = :fatta WHERE idUscita = :idUscita");
            $sql->bindParam(':fatta', $fatta);
            $sql->bindParam(':idUscita', $idUscita);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }

/************GESTIONE ENTRATE*************************/
    public function qAggEntrataP($nome,$dReg,$dPag,$imp,$idC,$detrazioni){
        $db=$this->connect();
        try{
            //print_r($detrazioni);
            if ($detrazioni!=0){
                $detrTot=0;
                foreach($detrazioni as $det){
                    if (($det->voce!=null) or ($det->voce!='')){
                        $detrTot += $det->valore;
                       /* $sql = $db->prepare("SELECT categoria FROM nomeuscita WHERE nome = :nomeU");
                        $sql->bindParam(':nomeU', $det->voce);
                        if ($sql->execute()){
                            $res = $sql->fetch();*/
                            $sql = $db->prepare("INSERT INTO detrazioni (nome, tipo, data, importo)
                            VALUES (:voce, :tipo, :dataFattura, :importo)");
                            $sql->bindParam(':voce', $det->voce);
                            $e='entrata';
                            $sql->bindParam(':tipo', $e);
                            $sql->bindParam(':dataFattura', $dReg);
                            $sql->bindParam(':importo', $det->valore);
                            $sql->execute();
                       /* }else{
                            return false;
                        }  */   
                    }
                }
                $imp-=$detrTot;
                //preparazione della query
                $sql=$db->prepare("INSERT INTO entrate (voce,dataFattura,dataPagamento,importo,fkCliente) ".
                                 "VALUES (:nome,:dReg,:dPag,:imp,:idC)");
                //binding dei parametri
                $sql->bindParam(':nome',$nome);
                $sql->bindParam(':dReg',$dReg);
                $sql->bindParam(':dPag',$dPag);
                $sql->bindParam(':imp',$imp);
                $sql->bindParam(':idC',$idC);
                //esecuzione della query
                if($sql->execute()){
                    return true;
                }else{
                    return false;
                }
            }else{
               //preparazione della query
                $sql=$db->prepare("INSERT INTO entrate (voce,dataFattura,dataPagamento,importo,fkCliente) ".
                                 "VALUES (:nome,:dReg,:dPag,:imp,:idC)");
                //binding dei parametri
                $sql->bindParam(':nome',$nome);
                $sql->bindParam(':dReg',$dReg);
                $sql->bindParam(':dPag',$dPag);
                $sql->bindParam(':imp',$imp);
                $sql->bindParam(':idC',$idC);
                //esecuzione della query
                if($sql->execute()){
                    return true;
                }else{
                    return false;
                } 
            }

        }catch(PDOException $ex){
			$ex->getMessage();
		}
    }
    
    //elimina entrata
    public function qDeleteEntry($idEntrata){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM entrate WHERE idEntrata = :id");
            $sql->bindParam(':id', $idEntrata);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    public function qSearchC($nominativo){
        $db=$this->connect();
        try{
            $sql=$db->prepare("SELECT idCliente,ragSociale FROM clienti
                                WHERE ragSociale LIKE :nominativo");
            $nominativo=$nominativo."%";
            //binding dei parametri
            $sql->bindParam(':nominativo',$nominativo);
            if($sql->execute()){
                if($row = $sql->rowCount()>0){
                    while($res = $sql->fetch()){
                        $result[]=$res;
                    }
                    return $result;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
			$ex->getMessage();
			return false;
		}	   
    }
    
    //funzione per settare pagamento
    public function qSetPagato($idEntrata){
        $db=$this->connect();
        try{
            $sql=$db->prepare("UPDATE entrate SET fatto=1
                                WHERE idEntrata= :idEntrata");
            $sql->bindParam(':idEntrata',$idEntrata);
            //esecuzione della query
            if($sql->execute()){
				return true;
			}
            
         }catch(PDOException $ex){
			     $ex->getMessage();
			     return false;
		     }
    }
    
    //voci per detrazione importo fattura emessa
    public function qGetAllVociSpesa(){
        $db=$this->connect();
        try{
            $sql=$db->prepare("SELECT nomeDet FROM tipo_detrazioni");
            if($sql->execute()){
                if($row = $sql->rowCount()>0){
                    while($res = $sql->fetch()){
                        $result[]=$res;
                    }
                    return $result;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
			$ex->getMessage();
			return false;
		}	   
    }

/***********GESTIONE CLIENTI***************/
    //query elimina cliente
    public function qEliminaC($idCliente){
        $db=$this->connect();
        try{
            $sql=$db->prepare("DELETE FROM clienti
                                            WHERE idCliente= :idCliente");
            $sql->bindParam(':idCliente',$idCliente);
            //esecuzione della query
            if($sql->execute()){
				        return true;
			     }
            
         }catch(PDOException $ex){
			     $ex->getMessage();
			     return false;
		     }
    }
    
    public function qLoadCliente($idCliente){
        $db=$this->connect();
        try{
            $sql=$db->prepare("SELECT * FROM clienti WHERE idCliente= :idCliente");
            $sql->bindParam(':idCliente',$idCliente);
            //esecuzione della query
            if($sql->execute()){
				$result = $sql->fetch();
                return $result;
			 }
            
         }catch(PDOException $ex){
             $ex->getMessage();
             return false;
         }
    }
    
    //funzione per aggiungere cliente
    public function qAggCliente($codCliente, $rsociale,$citta,$indirizzo,$provincia,$comune,$cap,$telefono,$piva,$cf){
        $db=$this->connect();
        $sql=$db->prepare("INSERT INTO clienti (codCliente, ragSociale,citta,indirizzo,provincia,comune,CAP,telefono,pIva,CF)".
                             " VALUES (:codCliente, :rsociale,:citta,:indirizzo,:provincia,:comune,:cap,:telefono,:piva,:cf)");
        try{
            //esecuzione della query
            if($citta == ''){
                $citta= NULL;
            }else{
                $citta = ucfirst($citta);
            }
            if($indirizzo == ''){
                $indirizzo= NULL;
            }else{
                $indirizzo = ucfirst($indirizzo);
            }
            if($provincia == ''){
                $provincia= NULL;
            }else{
                $provincia = ucfirst($provincia);
            }
            if($comune == ''){
                $comune= NULL;
            }else{
                $comune = ucfirst($comune);
            }
            if($cap == ''){
                $cap= NULL;
            }
            if($telefono == ''){
                $telefono= NULL;
            }
            if($piva == ''){
                $piva= NULL;
            }
            if ($cf == ''){
                $cf = NULL;
            }else{
                $cf = strtoupper($cf);
            }
            
            $sql->bindParam(':rsociale',$rsociale);
            $sql->bindParam(':codCliente',$codCliente);
            $sql->bindParam(':citta',$citta);	
            $sql->bindParam(':indirizzo',$indirizzo);
            $sql->bindParam(':provincia',$provincia);
            $sql->bindParam(':comune',$comune);
            $sql->bindParam(':cap',$cap);
            $sql->bindParam(':telefono',$telefono);
            $sql->bindParam(':piva',$piva);
            $sql->bindParam(':cf',$cf);
            
            if ($sql->execute()){
                return true;
            }    
            
        }catch(PDOException $ex){
			     $ex->getMessage();
			     return false;
		}
        
    }
    
//funzione per modificare dati cliente
    public function qModCliente($idC, $codCliente, $rsociale,$citta,$indirizzo,$provincia,$comune,$cap,$telefono,$piva,$cf){
        $db=$this->connect();
        $sql=$db->prepare("UPDATE clienti SET codCliente = :codCliente, ragSociale=:rsociale, citta=:citta, indirizzo=:indirizzo, provincia=:provincia, comune=:comune, CAP=:cap, telefono=:telefono, pIva=:piva, CF=:cf
        WHERE idCliente = :idC");
        try{
            //esecuzione della query
            if($citta == ''){
                $citta= NULL;
            }else{
                $citta = ucfirst($citta);
            }
            if($indirizzo == ''){
                $indirizzo= NULL;
            }else{
                $indirizzo = ucfirst($indirizzo);
            }
            if($provincia == ''){
                $provincia= NULL;
            }else{
                $provincia = ucfirst($provincia);
            }
            if($comune == ''){
                $comune= NULL;
            }else{
                $comune = ucfirst($comune);
            }
            if($cap == ''){
                $cap= NULL;
            }
            if($telefono == ''){
                $telefono= NULL;
            }
            if($piva == ''){
                $piva= NULL;
            }
            if ($cf == ''){
                $cf = NULL;
            }else{
                $cf = strtoupper($cf);
            }
            $sql->bindParam(':idC',$idC);
            $sql->bindParam(':rsociale',$rsociale);
            $sql->bindParam(':codCliente',$codCliente);
            $sql->bindParam(':citta',$citta);	
            $sql->bindParam(':indirizzo',$indirizzo);
            $sql->bindParam(':provincia',$provincia);
            $sql->bindParam(':comune',$comune);
            $sql->bindParam(':cap',$cap);
            $sql->bindParam(':telefono',$telefono);
            $sql->bindParam(':piva',$piva);
            $sql->bindParam(':cf',$cf);
            
            if ($sql->execute()){
                return true;
            }    
            
        }catch(PDOException $ex){
			     $ex->getMessage();
			     return false;
		}
        
    }
    
    //scarico dati cliente su well
    public function qGetDatiCliente($idCliente){
        $db = $this->connect();
        try{
            $sql = $db->prepare("SELECT * FROM clienti WHERE idCliente = :id");
            $sql->bindParam(':id', $idCliente);
            if ($sql->execute()){
                $result = $sql->fetch(PDO::FETCH_ASSOC);
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }

/**************** GRAFICI SPESA *************/
    public function qChartExpenseYear(){
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT YEAR(dataPagamento) AS anno, SUM(importo) as totaleSpesa
                                FROM uscite
                                WHERE fatta=1
                                GROUP BY YEAR(dataPagamento)
                                LIMIT 0,9");
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartExpenseMonth(){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT MONTH(dataPagamento) AS mese, SUM(importo) as tot
                                FROM uscite
                                WHERE fatta=1 AND dataPagamento LIKE :anno
                                GROUP BY MONTH(dataPagamento)");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartExpenseCategory(){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
            $sql = $db->prepare("SELECT SUM(importo) as totAnno
                                FROM uscite
                                WHERE fatta=1 AND dataPagamento LIKE :anno");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    $totale = $sql->fetch();
                    $sql = $db->prepare("SELECT uscite.categoria, SUM(importo) as totCategoria, colore
                                        FROM uscite JOIN tipouscita
                                        ON uscite.categoria = tipouscita.categoria
                                        WHERE fatta=1 AND dataPagamento LIKE :anno
                                        GROUP BY categoria");
                    $sql->bindParam(':anno', $year);
                    if ($sql->execute()){
                        $incidenza=array();
                        $i=0;
                        while($res = $sql->fetch()){
                            $incidenza[$i]['incidenza'] = round(($res['totCategoria']/$totale['totAnno']) * 100, 2);
                            $incidenza[$i]['categoria'] = '% '.$res['categoria'];
                            $incidenza[$i]['colore'] = $res['colore'];
                            $i++;
                        }
                        return $incidenza;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartExpenseName(){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
            $sql = $db->prepare("SELECT SUM(importo) as totAnno
                                FROM uscite
                                WHERE fatta=1 AND dataPagamento LIKE :anno");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                if ($sql->rowCount() > 0){
                    $totale = $sql->fetch();
                    $sql = $db->prepare("SELECT voce, SUM(importo) as totVoce, colore
                                        FROM uscite JOIN nomeuscita
                                        ON uscite.voce=nomeuscita.nome
                                        WHERE fatta=1 AND dataPagamento LIKE :anno
                                        GROUP BY voce");
                    $sql->bindParam(':anno', $year);
                    if ($sql->execute()){
                        $incidenza=array();
                        $i=0;
                        while($res = $sql->fetch()){
                            $incidenza[$i]['incidenza'] = round(($res['totVoce']/$totale['totAnno']) * 100, 2);
                            $incidenza[$i]['voce'] = '% '.$res['voce'];
                            $incidenza[$i]['colore'] = $res['colore'];
                            $i++;
                        }
                        return $incidenza;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartLineExpenseCat(){
        $db = $this->connect();
        try{
            $anni=array();
            $sql = $db->prepare("SELECT DISTINCT categoria, colore
                                FROM tipouscita");
           
            if ($sql->execute()){
                if ($sql->rowCount() > 0){
                    while ($res = $sql->fetch()){
                        $categorie[]=$res['categoria'];
                        $coloriCat[]=$res['colore'];
                        $sql2 = $db->prepare("SELECT DISTINCT YEAR(dataPagamento) as anno
                                            FROM uscite
                                            WHERE fatta=1
                                            LIMIT 0,9");
                        if ($sql2->execute()){
                            $x=0;
                            while ($res2 = $sql2->fetch()){
                                if ($x>0){
                                    if (!in_array($res2['anno'], $anni)){
                                        $anni[$x] = $res2['anno'];
                                        $x++;
                                    }
                                }else{
                                    $anni[$x] = $res2['anno'];
                                    $x++;
                                }
                                
                                $sql3 = $db->prepare("SELECT SUM(importo) as totAnno
                                                    FROM uscite
                                                    WHERE fatta=1 AND YEAR(dataPagamento) = :anno");
                                $sql3->bindParam(':anno', $res2['anno']);
                                if ($sql3->execute()){
                                    $totAnnoCorrente = $sql3->fetch();
                                    $sql4 = $db->prepare("SELECT SUM(importo) as totCatAnno
                                                        FROM uscite
                                                        WHERE fatta=1
                                                        AND YEAR(dataPagamento) = :anno
                                                        AND categoria = :categoria");
                                    $sql4->bindParam(':anno', $res2['anno']);
                                    $sql4->bindParam(':categoria', $res['categoria']);
                                    if ($sql4->execute()){
                                        $res3 = $sql4->fetch();
                                        $valori[] = round(($res3['totCatAnno']/$totAnnoCorrente['totAnno']) * 100, 2);
                                    }else{
                                        return false;
                                    }
                                }else{
                                    return false;
                                }
                            }
                            $valoriCat[$res['categoria']]=$valori;
                            $valori=array();
                        }else{
                            return false;
                        }
                    }
                    return $array = array("anni" => $anni,
                                        "categorie" => $categorie,
                                        "valori" => $valoriCat,
                                        "colori" => $coloriCat);
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartLineExpenseVoce(){
        $db = $this->connect();
        try{
            $anni=array();
            $sql = $db->prepare("SELECT DISTINCT nome, colore
                                FROM nomeuscita");
           
            if ($sql->execute()){
                if ($sql->rowCount() > 0){
                    while ($res = $sql->fetch()){
                        $voci[]=$res['nome'];
                        $coloriVoci[]=$res['colore'];
                        $sql2 = $db->prepare("SELECT DISTINCT YEAR(dataPagamento) as anno
                                            FROM uscite
                                            WHERE fatta=1
                                            LIMIT 0,9");
                        if ($sql2->execute()){
                            $x=0;
                            while ($res2 = $sql2->fetch()){
                                if ($x>0){
                                    if (!in_array($res2['anno'], $anni)){
                                        $anni[$x] = $res2['anno'];
                                        $x++;
                                    }
                                }else{
                                    $anni[$x] = $res2['anno'];
                                    $x++;
                                }
                                
                                $sql3 = $db->prepare("SELECT SUM(importo) as totAnno
                                                    FROM uscite
                                                    WHERE fatta=1 AND YEAR(dataPagamento) = :anno");
                                $sql3->bindParam(':anno', $res2['anno']);
                                if ($sql3->execute()){
                                    $totAnnoCorrente = $sql3->fetch();
                                    $sql4 = $db->prepare("SELECT SUM(importo) as totVoceAnno
                                                        FROM uscite
                                                        WHERE fatta=1
                                                        AND YEAR(dataPagamento) = :anno
                                                        AND voce = :nome");
                                    $sql4->bindParam(':anno', $res2['anno']);
                                    $sql4->bindParam(':nome', $res['nome']);
                                    if ($sql4->execute()){
                                        $res3 = $sql4->fetch();
                                        $valori[] = round(($res3['totVoceAnno']/$totAnnoCorrente['totAnno']) * 100, 2);
                                    }else{
                                        return false;
                                    }
                                }else{
                                    return false;
                                }
                            }
                            $valoriVoce[$res['nome']]=$valori;
                            $valori=array();
                        }else{
                            return false;
                        }
                    }
                    return $array = array("anni" => $anni,
                                        "voci" => $voci,
                                        "valori" => $valoriVoce,
                                        "colori" => $coloriVoci);
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
/****************************GRAFICI ENTRATE********************************************/
    public function qChartEntryYear(){
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT YEAR(dataPagamento) AS anno, SUM(importo) as totale
                                FROM entrate
                                WHERE fatto=1
                                GROUP BY YEAR(dataPagamento)
                                LIMIT 0,9");
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartEntryMonth(){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT MONTH(dataPagamento) AS mese, SUM(importo) as tot
                                FROM entrate
                                WHERE fatto=1 AND dataPagamento LIKE :anno
                                GROUP BY MONTH(dataPagamento)");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartClienteAnni($idC){
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT YEAR(dataPagamento) AS anno, SUM(importo) as totale
                                FROM entrate
                                WHERE fatto=1 AND fkCliente = :idC
                                GROUP BY YEAR(dataPagamento)
                                LIMIT 0,9");
            $sql->bindParam(':idC', $idC);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qChartClienteMesi($idC){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
           $sql = $db->prepare("SELECT DISTINCT MONTH(dataPagamento) AS mese, SUM(importo) as tot
                                FROM entrate
                                WHERE fatto=1 AND dataPagamento LIKE :anno AND fkCliente = :idC
                                GROUP BY MONTH(dataPagamento)");
            $sql->bindParam(':anno', $year);
            $sql->bindParam(':idC', $idC);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    while($res = $sql->fetch()){
                        $result[] = $res;
                    }
                    return $result;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
    public function qIncidenzaTotale($idC){
        $year = date('Y');
        $year .='%'; 
        $db = $this->connect();
        try{
            $sql = $db->prepare("SELECT SUM(importo) as totAnno
                                FROM entrate
                                WHERE fatto=1 AND dataPagamento LIKE :anno");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                if ($row = $sql->rowCount() > 0){
                    $totale = $sql->fetch();
                    $sql = $db->prepare("SELECT SUM(importo) as totaleC
                                        FROM entrate
                                        WHERE fatto=1 AND fkCliente = :idC AND dataPagamento LIKE :anno");
                    $sql->bindParam(':anno', $year);
                    $sql->bindParam(':idC', $idC);
                    if ($sql->execute()){
                        $res = $sql->fetch();
                        if ($totale['totAnno']==null){
                            $incidenza = 0;
                        }else{
                            $incidenza = round(($res['totaleC']/$totale['totAnno']) *100, 2);
                        }
                        return $incidenza;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
                
            }else{
                return false;
            }
            
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }
    }
    
/***********************PROFILO*********************************/
    //AGGIORNAMENTO PROFILO
    public function qUpdateUser($nome, $cognome, $email, $indirizzo, $citta, $comune, $provincia, $cap, $cellulare, $telefono, $pIva, $cf){
			$db=$this->connect();
			try{
				$sql=$db->prepare("UPDATE user SET email = :email, 
									nome = :nome, 
									cognome = :cognome,
									indirizzo = :indirizzo,  
									citta = :citta,  
									CF = :cf,
									cellulare = :cellulare,
									telefono = :telefono,
									comune = :comune,
                                    provincia = :provincia,
                                    cap = :cap,
									pIva = :pIva
									WHERE idUser = :idUser");
									
				$sql->bindParam(':idUser',$_SESSION['user']['idUser']);									
				$sql->bindParam(':email',$email);
				$sql->bindParam(':nome', ucfirst($nome));
				$sql->bindParam(':cognome',ucfirst($cognome));
                
                if (($indirizzo=='') or ($indirizzo=='-')){
                    $indirizzo=NULL;
                }
                if (($citta=='') or ($citta=='-')){
                    $citta=NULL;
                }else{
                    $citta=ucfirst($citta);
                }
                if (($cellulare=='') or ($cellulare=='-')){
                    $cellulare=NULL;
                }
                if (($telefono=='') or ($telefono=='-')){
                    $telefono=NULL;
                }
                if (($comune=='') or ($comune=='-')){
                    $comune=NULL;
                }else{
                    $comune = ucfirst($comune);
                }
                if (($provincia=='') or ($provincia=='-')){
                    $provincia=NULL;
                }else{
                    $provincia=strtoupper($provincia);
                }
                if (($cap=='') or ($cap=='-')){
                    $cap=NULL;
                }
                if (($pIva=='') or ($pIva=='-')){
                    $pIva=NULL;
                }else{
                    $pIva=strtoupper($pIva);
                }
                if (($cf=='') or ($cf=='-')){
                    $cf=NULL;
                }else{
                    $cf=strtoupper($cf);
                }
                
				$sql->bindParam(':indirizzo',$indirizzo);
				$sql->bindParam(':citta',$citta);
				$sql->bindParam(':cf',$cf);
				$sql->bindParam(':cellulare',$cellulare);
				$sql->bindParam(':telefono',$telefono);
				$sql->bindParam(':comune',$comune);
                $sql->bindParam(':provincia',$provincia);
                $sql->bindParam(':cap',$cap);
				$sql->bindParam(':pIva',$pIva);
				if($sql->execute()){
					$sql=$db->prepare("SELECT * FROM user WHERE idUser = :idUser");
					$sql->bindParam(':idUser', $_SESSION['user']['idUser']);
					if ($sql->execute()){
						if ($row = $sql->rowCount()>0){
							$res = $sql->fetch();
							return $res;
						}
					}
				}else{
					return false;
				}	
			}catch(PDOException $ex){
				$ex->getMessage();
				return false;
			}	
		}
    
    /*******************************IMPOSTAZIONI****************************************/
    
    //elimina categoria spesa
    public function qDeleteCategory($cat){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM tipouscita WHERE categoria = :cat");
            $sql->bindParam(':cat', $cat);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //elimina voce spesa
    public function qDeleteVoce($voce){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM nomeuscita WHERE nome = :voce");
            $sql->bindParam(':voce', $voce);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
 //elimina voce det
    public function qDeleteDetrazione($voce){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM tipo_detrazioni WHERE nomeDet = :voce");
            $sql->bindParam(':voce', $voce);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //aggiunta categoria
    public function qAddCategory($categoria, $coloreC){
        $db=$this->connect();
        try{
            $sql = $db->prepare("INSERT INTO tipouscita (categoria, colore)
                                VALUES (:cat, :colore)");
            $sql->bindParam(':colore', $coloreC);
            $sql->bindParam(':cat', $categoria);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //aggiunta voce
    public function qAddVoce($categoria, $coloreV, $voce){
        $db=$this->connect();
        try{
            $sql = $db->prepare("INSERT INTO nomeuscita (nome, colore, categoria)
                                VALUES (:voce, :colore, :cat)");
            $sql->bindParam(':colore', $coloreV);
            $sql->bindParam(':cat', $categoria);
            $sql->bindParam(':voce', $voce);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
//aggiunta voce det
    public function qAddDet($nome){
        $db=$this->connect();
        try{
            $sql = $db->prepare("INSERT INTO tipo_detrazioni VALUES (:voce)");
            $sql->bindParam(':voce', $nome);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    /***************************RIEPILOGO*********************************/
    
    //numero spese odierne
    public function qGetTodayExpense(){
        $today = date('Y-m-d');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT COUNT(idUscita) as num
                                FROM uscite
                                WHERE fatta=0 AND dataPagamento = :today");
            $sql->bindParam(':today', $today);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //numero entrate odierne
    public function qGetTodayEntry(){
        $today = date('Y-m-d');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT COUNT(idEntrata) as num
                                FROM entrate
                                WHERE fatto=0 AND dataPagamento = :today");
            $sql->bindParam(':today', $today);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //numero insoluti
    public function qGetInsoluti(){
        $today = date('Y-m-d');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT COUNT(idUscita) as num
                                FROM uscite
                                WHERE fatta=0 AND dataPagamento < :today");
            $sql->bindParam(':today', $today);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //numero entrate non ricevute
    public function qGetEntryNotReiceved(){
        $today = date('Y-m-d');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT COUNT(idEntrata) as num
                                FROM entrate
                                WHERE fatto=0 AND dataPagamento < :today");
            $sql->bindParam(':today', $today);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //totale spese
    public function qGetTotExpense(){
        $year = date('Y');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT SUM(importo) as tot
                                FROM uscite
                                WHERE fatta=1 AND YEAR(dataPagamento) = :anno");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //totale entrate
    public function qGetTotEntry(){
        $year = date('Y');
        $db=$this->connect();
        try{
            $sql = $db->prepare("SELECT SUM(importo) as tot
                                FROM entrate
                                WHERE fatto=1 AND YEAR(dataPagamento) = :anno");
            $sql->bindParam(':anno', $year);
            if ($sql->execute()){
                $result[]=$res = $sql->fetch();
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    //grafico confronto entrate uscite
    public function qChartCompare(){
        $mesi = array('01','02','03','04','05','06','07','08','09','10','11','12');
        $db = $this->connect();
        try{
            foreach($mesi as $m){
               $sql = $db->prepare("SELECT SUM(importo) as totE
                                FROM entrate
                                WHERE dataPagamento LIKE :data AND fatto=1");
                $data=date('Y').'-'.$m.'%';
                $sql->bindParam(':data', $data);
                if ($sql->execute()){
                    while($res = $sql->fetch()){
                        if ($res['totE']==null){
                            $entrate[] = 0;
                        }else{
                            $entrate[] = $res['totE'];
                        }  
                    }
                }else{
                    return false;
                }
                
                $sql = $db->prepare("SELECT SUM(importo) as totU
                                FROM uscite
                                WHERE dataPagamento LIKE :data AND fatta=1");
                $sql->bindParam(':data', $data);
                if ($sql->execute()){
                    while($res = $sql->fetch()){
                        if ($res['totU']==null){
                            $uscite[] = 0;
                        }else{
                            $uscite[] = $res['totU'];
                        }
                    }
                }else{
                    return false;
                }
                
            }
            return $array=array("mesi" => $mesi,
                               "entrate" => $entrate,
                               "uscite" => $uscite);
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
        
    //grafico confronto entrate uscite negli anni
    public function qChartCompareYears(){
        $db = $this->connect();
        for ($i=0; $i<10; $i++){
            $anni[]=date('Y')-$i;
        }
        
        try{
            foreach($anni as $a){
               $sql = $db->prepare("SELECT SUM(importo) as totE
                                    FROM entrate
                                    WHERE YEAR(dataPagamento) = :data AND fatto=1");
                $sql->bindParam(':data', $a);
                if ($sql->execute()){
                    while($res = $sql->fetch()){
                        if ($res['totE']==null){
                            $entrate[] = 0;
                        }else{
                            $entrate[] = $res['totE'];
                        }  
                    }
                }else{
                    return false;
                }
                
                $sql = $db->prepare("SELECT SUM(importo) as totU
                                FROM uscite
                                WHERE YEAR(dataPagamento) = :data AND fatta=1");
                $sql->bindParam(':data', $a);
                if ($sql->execute()){
                    while($res = $sql->fetch()){
                        if ($res['totU']==null){
                            $uscite[] = 0;
                        }else{
                            $uscite[] = $res['totU'];
                        }
                    }
                }else{
                    return false;
                }
                
            }
            return $array=array("anni" => $anni,
                               "entrate" => $entrate,
                               "uscite" => $uscite);
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        } 
    }
    
//elimina detrazione E
    public function qDeleteDetE($id){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM detrazioni WHERE idDetrazione = :idDetrazione");
            $sql->bindParam(':idDetrazione', $id);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
//elimina detrazione E
    public function qDeleteDetU($id){
        $db=$this->connect();
        try{
            $sql = $db->prepare("DELETE FROM detrazioni WHERE idDetrazione = :idDetrazione");
            $sql->bindParam(':idDetrazione', $id);
            if ($sql->execute()){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            $ex->getMessage();
            return false;
        }  
    }
    
    
}

?>
