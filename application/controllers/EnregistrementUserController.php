<?php
/**
 * Controller enregistrement de l'uitlisateur l'application, correspond à la page enregistrement utilisateur du site
 * 
 * @category Application
 * @author Xavier
 * @version 0.0.1
 */
class EnregistrementUserController extends Controller
{    
    /*
    *Fonction index appellé si aucune action spécifié en paramètre ou action invalide
    *
    */
    public function index()
    {
        $this->loadModel('User','form');
        $this->view->form = $this->User->form;
        echo "test";
    }
    /**
    * Permet d'enregistrr un utilisateur dans la table User et user
    **/
    function EnregistrementUser($id = null){
        $this->loadModel('User','form'); 
        $this->view->form = $this->User->form;

        if($this->request->data){
            if($this->User->validates($this->request->data)){
                //On commence par enregistrer les informations dans la table user
                $this->User->table = 'users';
              //  $dataToUser['password'] = $this->request->data->mdp ;
              //  $dataToUser['admin'] = 0 ;
            //    $this->User->save($dataToUser);
            //    $idLastUser = $this->User->db->lastinsertId();

                // On eneleve le email_confirmation et mdp_confirmation et submit avant d'executer la requete dans la table User
                $dataToUser = $this->request->data;
             //   $dataToUser->iduser = $idLastUser;
             //   $dataToUser->date_ajout = date("Y-m-d");
                unset($dataToUser->civilite);
                unset($dataToUser->email_confirmation);
                unset($dataToUser->mdp_confirmation);
                unset($dataToUser->submit);

                $this->User->table = 'Users';
                $this->User->save($dataToUser);

                $this->Session->setFlash('Votre compte a bien été crée');
                //$this->redirect('home');
            }else{
                $this->Session->setFlash('Merci de corriger vos informations','error'); 
            }      
        }elseif($id){
            $this->request->data = $this->User->findFirst(array(
                'conditions' => array('id'=>$id)
            ));
        }
        //$d['id'] = $id; 
        //$this->set($d);
    }

}