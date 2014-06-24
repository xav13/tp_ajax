<?php
require MODEL_PATH . DS . 'User.php'; 
/**
 * Controller enregistrement de l'uitlisateur l'application, correspond à la page enregistrement utilisateur du site
 * 
 * @category Application
 * @author Xavier
 * @version 0.0.1
 */
class MoncompteController extends Controller
{    
    /*
    *Fonction index appellé si aucune action spécifié en paramètre ou action invalide
    *
    */
    public function index()
    {
    	$this->loadModel('User');
    	$this->view->infos_User = $this->User->getInfoUser($_SESSION['email_User']);
    }
    public function listecommandes()
    {
    	$this->view->setRoute('mescommandes');
    	$this->loadModel('Commande');
    	$this->loadModel('User');
    	$this->view->infos_User = $this->User->getInfoUser($_SESSION['email_User']);
    	$idUser = $this->view->infos_User['idUser'];
    	$this->view->commandes = $this->Commande->getCommandesUser($idUser);
    }
    public function mesinformation(){
    	
    }
}