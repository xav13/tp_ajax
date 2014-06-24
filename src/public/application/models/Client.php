<?php

class Client extends Model
{
	var $validate = array(
		'nom' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser un nom'
		),
		'prenom' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser un prénom'
		),
		'adresse' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser une adresse'
		),
		'code_postal' => array(
			'rule' => '^\d+$',
			'message' => 'Vous devez préciser un code postal valide'
		),
		'email' => array(
			'rule' => '^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$',
			'message' => 'Vous devez préciser une adresse mail valide'
		),
		'ville' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez préciser une ville'
		),
		'telephone' => array(
			'rule' => '^\d+$',
			'message' => 'Vous devez préciser un numéro de téléphone valide'
		),
		'mdp_confirmation' => array(
			'rule' => 'egualMdp',
			'message' => 'Confirmation du mot de passe incorrect'
		),
		'email_confirmation' => array(
			'rule' => 'egualEmail',
			'message' => 'Confirmation de l\'email incorrect'
		),
		'mdp' => array(
			'rule' => 'notEmpty',
			'message' => 'Vous devez précisez un mot de passe'
		)
	);

    public $clients = array();
    var $table = 'clients';
            
    public function getClients()
    { 
        $req = $this->db->prepare("SELECT * FROM clients");
		$req->execute();
		return $req;
    }
    public function getInfoClient($email_client)
    { 
    	$infos = array();
        $req = $this->db->prepare("SELECT * FROM clients WHERE email = '$email_client' ");
		$req->execute();
		foreach ($req as $r) {
			$infos['iduser'] = $r['iduser'];
			$infos['societe'] = $r['societe'];
			$infos['idclient'] = $r['idclient'];
			$infos['civilite'] = $r['civilite'];
			$infos['nom'] = $r['nom'];
			$infos['prenom'] = $r['prenom'];
			$infos['adresse'] = $r['adresse'];
			$infos['code_postal'] = $r['code_postal'];
			$infos['ville'] = $r['ville'];
			$infos['email'] = strtolower($r['email']);
			$infos['date_ajout'] = $r['date_ajout'];
		}
		return $infos;
	}
	public function getLastIdUser()
	{
		$sql = "SELECT LAST_INSERT_ID() FROM users";
		$this->db->query($sql);
		return $this->db->lastinsertId();
	}
	public function getInfoUser($iduser)
    { 
    	$infos = array();
        $req = $this->db->prepare("SELECT * FROM users WHERE iduser = '$iduser' ");
		$req->execute();
		foreach ($req as $r) {
			$infos['iduser'] = $r['iduser'];
			$infos['password'] = $r['password'];
			$infos['login'] = $r['login'];
			$infos['admin'] = $r['admin'];
		}
		return $infos;
	}
	public function isAdmin($iduser)
    {
        $infos = $this->getInfoUser($iduser);
            if ($infos['admin'] == 1){
                return true;
            }else{
                return false;
            }
    }
}

