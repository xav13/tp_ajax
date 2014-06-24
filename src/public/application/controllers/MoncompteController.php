<?php
require MODEL_PATH . DS . 'Client.php'; 
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
    	$this->loadModel('Client');
    	$this->view->infos_client = $this->Client->getInfoClient($_SESSION['email_client']);
    }
    public function listecommandes()
    {
    	$this->view->setRoute('mescommandes');
    	$this->loadModel('Commande');
    	$this->loadModel('Client');
    	$this->view->infos_client = $this->Client->getInfoClient($_SESSION['email_client']);
    	$idclient = $this->view->infos_client['idclient'];
    	$this->view->commandes = $this->Commande->getCommandesClient($idclient);
    }
    public function mesinformation(){
    	
    }
}