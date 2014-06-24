<?php 
/**
 * Objet Response
 * Cet objet représente la réponse HTTP qui sera renvoyée
 * par le serveur HTTP au client à la fin de l'exécution
 * 
 * @category IPLIB
 * @author Formateur
 * @version 0.0.1
 */
class Response
{
    /**
     * @var int
     */
    private $httpResponseCode = 200;
    /**
     * @var array
     */
    private $headers = array();
    /**
     * @var string
     */
    private $body;
    
    /**
     * Tableau de correspondance Code HTTP / Message
     * @var array 
     */
    private static $httpCodes = array(
    	200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal Server Error'  
    );
	/**
     * @return the $httpResponseCode
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

	/**
     * @param number $httpResponseCode
     */
    public function setHttpResponseCode($httpResponseCode)
    {
        $this->httpResponseCode = $httpResponseCode;
    }

	/**
     * @return the $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

	/**
     * @param string $header
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

	/**
     * @return the $body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Renvoie la liste des codes HTTP supportés par l'objet Response
     * @return multitype:
     */
    public static function getHttpCodes()
    {
        return self::$httpCodes;
    }
	/**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    public function send()
    {
        header("HTTP/1.1 {$this->httpResponseCode} " . self::$httpCodes[$this->httpResponseCode]);
        
        foreach($this->headers as $header) {
            header($header);
        }
        
        echo $this->body;
    }

    
}