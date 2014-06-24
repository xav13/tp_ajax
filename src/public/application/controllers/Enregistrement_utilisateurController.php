<?php
/**
 * Controller enregistrement de l'uitlisateur l'application, correspond à la page enregistrement utilisateur du site
 * 
 * @category Application
 * @author Xavier
 * @version 0.0.1
 */
class Enregistrement_utilisateurController extends Controller
{    
    /*
    *Fonction index appellé si aucune action spécifié en paramètre ou action invalide
    *
    */
    public function index()
    {
        $this->loadModel('Client','form');
        $this->view->form = $this->Client->form;
    }
    /**
    * Permet d'enregistrr un utilisateur dans la table client et user
    **/
    function EnregistrementUtilisateur($id = null){
        $this->loadModel('Client','form'); 
        $this->view->form = $this->Client->form;

        if($this->request->data){
            if($this->Client->validates($this->request->data)){
                //On commence par enregistrer les informations dans la table user
                $this->Client->table = 'users';
                $dataToUser['password'] = $this->request->data->mdp ;
                $dataToUser['admin'] = 0 ;
                $this->Client->save($dataToUser);
                $idLastUser = $this->Client->db->lastinsertId();

                // On eneleve le email_confirmation et mdp_confirmation et submit avant d'executer la requete dans la table Client
                $dataToClient = $this->request->data;
                $dataToClient->iduser = $idLastUser;
                $dataToClient->date_ajout = date("Y-m-d");
                unset($dataToClient->email_confirmation);
                unset($dataToClient->mdp_confirmation);
                unset($dataToClient->mdp);
                unset($dataToClient->submit);

                $this->Client->table = 'clients';
                $this->Client->save($dataToClient);

                $this->Session->setFlash('Votre compte a bien été crée');
                //$this->redirect('home');
            }else{
                $this->Session->setFlash('Merci de corriger vos informations','error'); 
            }      
        }elseif($id){
            $this->request->data = $this->Client->findFirst(array(
                'conditions' => array('id'=>$id)
            ));
        }
        //$d['id'] = $id; 
        //$this->set($d);
    }

}