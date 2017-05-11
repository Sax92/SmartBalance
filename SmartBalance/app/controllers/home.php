<?php
if (!isset($_SESSION['user'])){
   session_start(); 
}

class Home extends Controller{
	
	//funzione che richiama la homepage
	public function index(){
		global $config;
		//controllo se utente esiste altrimenti, redirect al login
		if (isset($_SESSION['user'])){
            header("Location: ".$config['path_base']."userManager/");			
		}else if(isset($_COOKIE['user'])){
            $login=explode(',',$_COOKIE['user']);
            $this->loginCookie($login[0],$login[1]);
        }else{
			$this->view('home/index');
		}	
	}
	
	//funzione che effettua il login e inizializza l'utente
	public function login(){
		global $config;
		$db=new Db();
        $result = $db->qLogin($_POST['email'],$_POST['pwd']);
		if ($result != false){
            if ($_POST['remember']==1){
                setcookie('user',$_POST['email'].','.md5($_POST['pwd']), time()+(15*24*3600));
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
                echo 'success';
            }else{
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
                echo 'success';
            }
			
		}else{
			echo 'error';
		}
	}
    
    //login richiamata solo se cookie presente
    public function loginCookie($email,$pwd){
        $db=new Db();
        $result = $db->qLogin($email, $pwd);
        if ($result!=false){
            $user = unserialize(serialize($this->model('User',$result)));	
            $_SESSION['user']=array();
            $_SESSION['user']['idUser']=$user->idUser;
            $_SESSION['user']['nome']=($user->nome != NULL) ? $user->nome:'-';
            $_SESSION['user']['cognome']=($user->cognome != NULL) ? $user->cognome:'-';
            $_SESSION['user']['email']=$user->email;
            $_SESSION['user']['password']=$user->password;
            $_SESSION['user']['indirizzo']=($user->indirizzo != NULL) ? $user->indirizzo:'-';
            $_SESSION['user']['citta']=($user->citta != NULL) ? $user->citta:'-';
            $_SESSION['user']['comune']=$user->comune;
            $_SESSION['user']['provincia']=$user->provincia;
            $_SESSION['user']['cap']=$user->cap;
            $_SESSION['user']['cellulare']=($user->cellulare != NULL) ? $user->cellulare:'-';
            $_SESSION['user']['telefono']=($user->telefono != NULL) ? $user->telefono:'-';
            $_SESSION['user']['pIva']=($user->pIva != NULL) ? $user->pIva:'-';
            $_SESSION['user']['cf']=($user->cf != NULL) ? $user->cf:'-';
            //faccio il redirect
            header("Location: ".$config['path_base']."userManager/");    
        }
    }
	
	//funzione configurazione utente ---DA IMPLEMENTARE SUCCESSIVAMENTE---
	public function register(){
		global $config;
		$db=new Db();
        $result=$db->qCheckEmail($_POST['email']);
        if ($result!=false){
            if($result=$db->qRegister($_POST['nome'],$_POST['cognome'],$_POST['email'],$_POST['pwd'],$_POST['fisso'],$_POST['cel'],$_POST['datana'],$_POST['citta'],$_POST['indirizzo'],$_POST['pIva'],$_POST['cf'])){
                include_once ('PHPMailer/PHPMailerAutoload.php'); 
                $mail = new PHPMailer;
                $mail->isSMTP();                                      
                $mail->Host = 'smtps.aruba.it';  
                $mail->SMTPAuth = true;                               
                $mail->Username = 'notifiche@spot-link.it';                 
                $mail->Password = 'forzaedo';                          
                $mail->SMTPSecure = 'ssl';                            
                $mail->Port = 465;                                    
                $mail->setFrom('notifiche@spot-link.it','Panel SpotLink');
                $mail->addAddress($_POST['email']);               
                $mail->isHTML(true);                                 
                $mail->Subject = 'Conferma iscrizione Spot-Link';
                $mail->Body = "Gentile Cliente, le confermiamo l'avvenuta iscrizione al sistema SpotLink. I suoi dati sono <br>Username: ". $_POST['email'] ."<br>Password: ". $_POST['pwd'] ."<br>Codice Coupon:". $result ."<br><img src=\"http://panel.spot-link.it/public/img/logo_spotlink.png\"/><br><img src=\"http://panel.spot-link.it/public/img/logo_emotion.png\"/>";
                $mail->AltBody = "Gentile Cliente, ti confermiamo l'avvenuta iscrizione al sistema SpotLink. I suoi dati sono <br>Username: ". $_POST['email'] ." Password: ". $_POST['pwd'] ." Codice Coupon: ". $result ."<br>";

                if (!$mail->send()){
                    echo $mail->ErrorInfo;
                }

                $this->view('home/confirm');	
            }
            else{
                $this->view('home/errorRegistration');
            }
        }else{
            $this->view('home/errorMail');
        }
	}
	
	public function logout(){
		global $config;
		unset($_SESSION['user']);
		session_unset();
        if (isset($_COOKIE['user'])){
            setcookie('user', null);
        }
		header("Location: ".$config['path_base']."home/");
	}
	
    //IN SOSPESO
	public function passwordLost(){
		$this->view('home/lostPassword');
	}

    //IN SOSPESO
	public function resetPassword(){
		$db=new Db();
		$result=$db->qCheckUser($_POST['email']);
		if ($result!=false){
            if (($_POST['pwdconf']=="") or ($_POST['pwdconf']==null)){
                echo "vuota";
            }else{
                if ($_POST['pwdnew']==$_POST['pwdconf']){
                    $pwdhashed=md5($_POST['pwdconf']);
                    $result=$db->qUpdatePassword($pwdhashed,$_POST['email']);
                    if($result!=false){
                        include_once ('PHPMailer/PHPMailerAutoload.php'); 
                        $mail = new PHPMailer;
                        $mail->isSMTP();                                      
                        $mail->Host = 'smtps.aruba.it';  
                        $mail->SMTPAuth = true;                               
                        $mail->Username = 'notifiche@spot-link.it';                 
                        $mail->Password = 'forzaedo';                          
                        $mail->SMTPSecure = 'ssl';                            
                        $mail->Port = 465;                                    
                        $mail->setFrom('notifiche@spot-link.it','Panel SpotLink');
                        $mail->addAddress($_POST['email']);               
                        $mail->isHTML(true);                                 
                        $mail->Subject = 'Conferma modifica password Spot-Link';
                        $mail->Body = "Gentile Cliente, le confermiamo l'avvenuta modifica della sua password. I suoi nuovi dati sono <br>Username: ". $_POST['email'] ."<br>Password: ". $_POST['pwdconf'] ."<br>
                        <img src=\"http://panel.spot-link.it/public/img/logo_spotlink.png\"/><br><img src=\"http://panel.spot-link.it/public/img/logo_emotion.png\"/>";
                        $mail->AltBody = "Gentile Cliente, ti confermiamo l'avvenuta modifica della tua password. I suoi nuovi dati sono Username: ". $_POST['email'] ." Password: ". $_POST['pwdconf'] ."";

                        if (!$mail->send()){
                            echo $mail->ErrorInfo;
                        }
                        echo "ok";
                    }
			     
                }else{
                    echo "notEqual";
                }
            }
			
		}else{
			echo "notPresent";
		}
	}
    
    //pagina 404
    public function pageNotFound(){
        $this->view('home/404');
    }
	
} 
?>