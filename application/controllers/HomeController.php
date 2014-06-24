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
        $this->loadModel('User','form'); 
        $this->view->form = $this->User->form;
    }
    /*
    *
    *Vérifie si l'email est correct sinon renvoie view->message = Emil non valide
    *Vérifie ensuite le mot de passe correspondant a l'email sinon renvoie $this->view = Mot de passe incorrect
    *Si tout est Ok $this->view = Bonjour bienvenu... puis session['email_User'] = a l'email du User    * 
    */

    public function connexion()
    {
    	$this->loadModel('User','form');
        $this->view->form = $this->User->form;
    	$this->view->message = "";
    	$email_User = strtolower($this->request->data->emaillog);
    	$password = $this->request->data->mdplog;
        $info_user = $this->User->getInfoUser($email_User);
    	$this->view->infos_User = $info_user;
    	if(!in_array($email_User,$info_user)){
    		$this->Session->setFlash('Email incorrect', 'error');
            return false;
    	}
    	if($info_user['mdp']!=$password){
    		$this->Session->setFlash('Mot de passe incorrect','error');
            return false;
    	}
    	if($info_user['mdp']==$password){
    		$this->Session->setFlash("Vous êtes bien connecté " .$this->view->infos_User['prenom'], "success");
  			//Enregistrement dans la variable de session $email_user de l'email du User connecté
            // Et ajout de la variable admin = 1 si l'utilisateur est admin
    		$this->Session->write('email_User',$this->view->infos_User['email']);
            if($info_user['admin']==1){
                $this->Session->setFlash("Vous êtes bien connecté " .$this->view->infos_User['prenom']. " en tant que Administrateur", "success");
                $this->Session->write('admin', true);
            }else{
                $this->Session->write('admin', false);
            }
    	}
    }
    public function deconnexion()
    {
        $this->loadModel('User','form');
        $this->view->form = $this->User->form;
    	unset($_SESSION['email_User']);
        unset($_SESSION['admin']);

    }
}