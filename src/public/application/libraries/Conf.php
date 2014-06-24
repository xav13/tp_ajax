<?php
class Conf{
	
	static $debug = 1; 
	static $databases = array(
//developpement
		'default' => array(
			'host'		=> 'localhost',
			'database'	=> 'tpajax',
			'login'		=> 'root',
			'password'	=> '0000'
//Production
/*		'default' => array(
			'host'		=> '',
			'database'	=> '',
			'login'		=> '',
			'password'	=> ''*/
		)
	);

}