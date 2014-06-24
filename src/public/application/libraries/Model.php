<?php
class Model
{
	
	static $connections = array(); 

	public $conf = 'default';
	public $table = false; 
	public $db; 
	public $primaryKey = 'idUser'; 
	public $id; 
	public $errors = array();
	public $form ; 
	public $validate = array();

	/**
	* Permet d'initialiser les variable du Model
	**/
	public function __construct(){
		// Nom de la table
		if($this->table === false){
			$this->table = strtolower(get_class($this)).'s'; 
		}
		
		// Connection à la base ou récupération de la précédente connection
		$conf = Conf::$databases[$this->conf];
		if(isset(Model::$connections[$this->conf])){
			$this->db = Model::$connections[$this->conf];
			return true; 
		}
		try{
			$pdo = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

			Model::$connections[$this->conf] = $pdo; 
			$this->db = $pdo; 
		}catch(PDOException $e){
			if(Conf::$debug >= 1){
				die($e->getMessage()); 
			}else{
				die('Impossible de se connecter à la base de donnée'); 
			}
		}
	}
	/**
	* Permet de valider des données
	* @param $data données à valider 
	**/
	function validates($data){
		$errors = array(); 
		foreach($this->validate as $k=>$v){
				if(!isset($data->$k)){
					$errors[$k] = $v['message']; 
				}else{
					if($v['rule'] == 'notEmpty'){
						if(empty($data->$k)){
							$errors[$k] = $v['message'];
						}
					}elseif($v['rule'] == 'egualMdp'){
						if($data->$k != $data->mdp){
							$errors[$k] = $v['message'];
						}
					}elseif($v['rule'] == 'egualEmail'){
						if($data->$k != $data->email){
							$errors[$k] = $v['message'];
						}
					}elseif(!preg_match('/^'.$v['rule'].'$/',$data->$k)){
						$errors[$k] = $v['message'];
					}
				}
		}
		$this->errors = $errors; 
		if(isset($this->form)){
			$this->form->errors = $errors; 
		}
		if(empty($errors)){
			return true;
		}
		return false;
	}
	/**
	* Permet de sauvegarder des données
	* @param $data Données à enregistrer
	**/
	public function save($data){
		$key = $this->primaryKey;
		$fields =  array();
		$d = array(); 
		foreach($data as $k=>$v){
			if($k!=$this->primaryKey){
				$fields[] = "$k=:$k";
				$d["$k"] = $v; 
			}elseif(!empty($v)){
				$d[":$k"] = $v; 
			}
		}
		if(isset($data->$key) && !empty($data->$key)){
			$sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key;
			$this->id = $data->$key; 
			$action = 'update';
		}else{
			$sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
			$action = 'insert'; 
		}
		$pre = $this->db->prepare($sql); 
		$pre->execute($d);
		if($action == 'insert'){
			$this->id = $this->db->lastInsertId(); 
		}
	}
}

