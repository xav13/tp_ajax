<?php 
/**
 * Objet Dispatcher
 * 
 * Cet objet déclenche, à partir d'un objet Request "routé", 
 * l'exécution de la couche MVC correspondante.
 * Il peuple ensuite l'objet Response avec le résultat généré
 * (headers éventuels, body)
 * 
 * @category IPLIB
 * @author Formateur
 * @version 0.0.1
 *
 */
class Dispatcher
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;
    
    /**
     * Constructeur
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    /**
     * Dispatch
     * Détermine, à partir de la route contenue dans la Request, le nom
     * du controller à exécuter, puis exécute ce controller
     */
    

    /* A modifier pour eviter de passer l'action et la vue si elle est différente de la vue de base en paramètre*/
    public function dispatch() 
    {
        $controllerName = ucfirst($this->request->getRoute()) . 'Controller';
        $controllerFile = $controllerName . '.php';
        $layout = 'tp.phtml';
        $params = $this->request->getParams();
        if (isset($params['view'])){
        $view = $params['view'];
        }else{
            $view = $this->request->getRoute();
        }
        require_once CONTROLLER_PATH . DS . $controllerFile;
        // Instanciation dynamique du controller
        $controller = new $controllerName($this->request, $this->response, $layout, $view);
        if (isset($params['action'])){
        $action = $params['action'];
        }else{
            $action='index';
        }
        if(method_exists($controllerName, $action)){
            $controller->$action();  // Si la méthode demandée en paramètre(?action=???) existe on appellera celle ci
        }else{
            $controller->index();  // Appel de la fonction par default
        }
    }
}