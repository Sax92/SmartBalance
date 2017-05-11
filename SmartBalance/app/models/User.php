<?php
class User{
	public $idUser;
	public $nome;
	public $cognome;
	public $email;
	public $password;
	public $indirizzo;
	public $citta;
	public $cellulare;
	public $telefono;
	public $pIva;
	public $cf;
    public $cap;
    public $comune;
    public $provincia;
	
	public function User($res=null){
		if ($res!=null){
			$this->idUser = $res['idUser'];
			$this->email = $res['email'];
			$this->password = $res['password'];
			$this->indirizzo = $res['indirizzo'];
			$this->citta = $res['citta'];
            $this->comune = $res['comune'];
            $this->provincia = $res['provincia'];
            $this->cap = $res['CAP'];
			$this->cellulare = $res['cellulare'];
			$this->telefono = $res['telefono'];
			$this->pIva = $res['pIva'];
			$this->cf = $res['CF'];
			$this->nome = $res['nome'];
			$this->cognome = $res['cognome'];
			
		}else{
			$this->idUser = "";
			$this->nome = "";
			$this->cognome = "";
			$this->email = "";
			$this->password = "";
			$this->indirizzo = "";
			$this->citta = "";
            $this->comune = "";
            $this->provincia = "";
            $this->cap = "";
			$this->cellulare = "";
			$this->telefono = "";
			$this->pIva = "";
			$this->cf = "";
		}
		
	}   
	
} 
?>