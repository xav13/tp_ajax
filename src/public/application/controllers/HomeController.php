<?php 
/**
 * Controller par défaut de l'application, correspond à la page d'index du site
 * 
 * @category Application
 * @author xavier
 * @version 0.0.1
 */
class HomeController extends Controller
{    
    /*
    *Fonction index appellé si aucune action spécifié en paramètre ou action invalide
    *
    */
    public function index()
    {
    }
    /*
    *
    *Vérifie si l'email est correct sinon renvoie view->message = Emil non valide
    *Vérifie ensuite le mot de passe correspondant a l'email sinon renvoie $this->view = Mot de passe incorrect
    *Si tout est Ok $this->view = Bonjour bienvenu... puis session['email_client'] = a l'email du client    * 
    */

    public function connection_user()
    {
    	$this->loadModel('Client');
    	$this->view->message = "";
    	$email_client = strtolower($this->request->data->email_log);
    	$password = $this->request->data->password;
    	$this->view->infos_client = $this->Client->getInfoClient($email_client);
    	if(!in_array($email_client,$this->view->infos_client)){
    		$this->Session->setFlash('Email incorrect', 'error');
            return false;
    	}
    	$info_user = $this->Client->getInfoUser($this->view->infos_client['iduser']);
    	if($info_user['password']!=$password){
    		$this->Session->setFlash('Mot de passe incorrect','error');
            return false;
    	}
    	if($info_user['password']==$password){
    		$this->Session->setFlash("Bienvenue sur notre site " .$this->view->infos_client['prenom']. ", Bonne visite!", "success");
  			//Enregistrement dans la variable de session $email_log de l'email du client connecté
    		$this->Session->write('email_client',$this->view->infos_client['email']);
    	}
    }
    public function deconnection()
    {
    	unset($_SESSION['email_client']);
    }
}