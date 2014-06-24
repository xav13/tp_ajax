<?php 

/**
 * Objet Router
 * Permet d'analyser une requête HTTP entrante 
 * (objet Request) pour déterminer la route interne de 
 * l'application (controller à appeler)
 * @category IPLIB
 * @version 0.0.1
 * @author Formateur
 *
 */
class Router
{
    /**
     * @var Request
     */
    private $request;
    
    /**
     * Constructeur
     * @param Request $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    /**
     * Analyse une URI et détermine
     * le nom du controlleur qui devra être chargé
     */
    public function route()
    {
        // Lire l'URL demandée par le client
        $uri = $this->request->getUrl();
        // on ne récupère que la partie sans query string de l'URI
        $uriPath = parse_url($uri, PHP_URL_PATH);
        $uriQueryString = parse_url($uri, PHP_URL_QUERY);
    
     //   $uriPath = str_replace('stage/src/public/','',$uriPath);//pour les test sur le serveur de madeleine ARNAL
        $route = strtolower($uriPath);
        
        if ('' == $route) {
            $route = 'home';
        }
        
        if (!file_exists(CONTROLLER_PATH . DS . ucfirst($route) . 'Controller.php')) {
            $route = 'error';
        }
        
        // Injecte la route déterminée ici dans l'objet Request
        $this->request->setRoute($route);
    }
}