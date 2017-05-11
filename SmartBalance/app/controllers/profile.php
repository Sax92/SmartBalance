<?php
session_start();
global $config;
if (!isset($_SESSION['user'])){
	header("Location: ".$config['path_base']."home/");
}

class Profile extends Controller{
	public function index(){
        $this->view('profile/userProfile');
	}

    
    //aggiornamento profilo
	public function updateUser(){
		$db = new Db();
		$result = $db->qUpdateUser($_POST['nome'],$_POST['cognome'], $_POST['email'], $_POST['indirizzo'], $_POST['citta'], $_POST['comune'], $_POST['provincia'], $_POST['cap'], $_POST['cellulare'], $_POST['telefono'], $_POST['pIva'], $_POST['cf']);
		if ($result != false){
			$ack="true";
            $user = unserialize(serialize($this->model('User',$result)));	
            $_SESSION['user']=array();
            $_SESSION['user']['idUser']=$user->idUser;
            $_SESSION['user']['nome']=($user->nome != NULL) ? $user->nome:'-';
            $_SESSION['user']['cognome']=($user->cognome != NULL) ? $user->cognome:'-';
            $_SESSION['user']['email']=$user->email;
            $_SESSION['user']['password']=$user->password;
            $_SESSION['user']['indirizzo']=($user->indirizzo != NULL) ? $user->indirizzo:'-';
            $_SESSION['user']['citta']=($user->citta != NULL) ? $user->citta:'-';
            $_SESSION['user']['comune']=($user->comune != NULL) ? $user->comune:'-';
            $_SESSION['user']['provincia']=($user->provincia != NULL) ? $user->provincia:'-';
            $_SESSION['user']['cap']=($user->cap != NULL) ? $user->cap:'-';
            $_SESSION['user']['cellulare']=($user->cellulare != NULL) ? $user->cellulare:'-';
            $_SESSION['user']['telefono']=($user->telefono != NULL) ? $user->telefono:'-';
            $_SESSION['user']['pIva']=($user->pIva != NULL) ? $user->pIva:'-';
            $_SESSION['user']['cf']=($user->cf != NULL) ? $user->cf:'-';
			echo $ack;
		}else{
			$ack="false";
			echo $ack;
		}
	}
	
	public function uploadPhoto(){
		global $config;
		//print_r($_FILES['userPhoto']);
		// per prima cosa verifico che il file sia stato effettivamente caricato
		if (!isset($_FILES['userPhoto']) || !is_uploaded_file($_FILES['userPhoto']['tmp_name'])) {
			echo 'Non hai inviato nessun file...';
			exit;    
		}
		
		// limito la dimensione massima a 4MB
		if ($_FILES['userPhoto']['size'] > 2194304) {
			echo 'Il file è troppo grande!';
			exit;
		}
		
		//verifico estensione file
		$ext_ok = array('jpg', 'gif', 'png');
		$temp = explode('.', $_FILES['userPhoto']['name']);
		$ext = end($temp);
		if (!in_array($ext, $ext_ok)) {
			echo 'Il file ha un estensione non ammessa!';
			exit;
		}
		
		$is_img = getimagesize($_FILES['userPhoto']['tmp_name']);
		if (!$is_img) {
			echo 'Puoi inviare solo immagini';
			exit;    
		}
		
		//percorso della cartella dove mettere i file caricati dagli utenti
		$uploaddir = 'img/usersPhoto/';
		/*if (is_writable($uploaddir)) {
    		echo 'The file is writable';
		} else {
    		echo 'The file is not writable';
		}*/
		
		//chmod($uploaddir, 0777);
		
		//Recupero il percorso temporaneo del file
		$userfile_tmp = $_FILES['userPhoto']['tmp_name'];
		
		//recupero il nome originale del file caricato
		//$userfile_name = $_FILES['userPhoto']['name'];
		$userfile_name = $_SESSION['user']['idUser'];
		
		//copio il file dalla sua posizione temporanea alla mia cartella upload
		if (move_uploaded_file($userfile_tmp, $uploaddir . $userfile_name)) {
			// Everything for owner, read and execute for owner's group
			chmod($uploaddir . $userfile_name, 0777);
			//Se l'operazione è andata a buon fine...
			//$_SESSION['user']['profileImg'] = 1;
			header("Location: ". $config['path_base'] ."profile/");
			//echo 'File inviato con successo.';
		}else{
			//Se l'operazione è fallta...
			echo 'Upload NON valido!'; 
		}
		
	}
	
	
}