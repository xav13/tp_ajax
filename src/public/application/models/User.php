<?php
class User extends Model
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
		'email' => array(
			'rule' => '^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$',
			'message' => 'Vous devez préciser une adresse mail valide'
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

    public $Users = array();
    var $table = 'Users';
            
    public function getUsers()
    { 
        $req = $this->db->prepare("SELECT * FROM Users");
		$req->execute();
		return $req;
    }
    public function getInfoUser($email_User)
    { 
    	$infos = array();
        $req = $this->db->prepare("SELECT * FROM Users WHERE email = '$email_User' ");
		$req->execute();
		foreach ($req as $r) {
			$infos['iduser'] = $r['iduser'];
			$infos['societe'] = $r['societe'];
			$infos['civilite'] = $r['civilite'];
			$infos['nom'] = $r['nom'];
			$infos['prenom'] = $r['prenom'];
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

