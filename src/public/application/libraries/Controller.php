<?php 

/**
 * Controller parent
 * 
 * @category 
 * @author Xavier
 * @version 0.0.1
 */
class Controller
{    
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    
    /**
     * @var View
     */
    protected $view;
    
    /**
     * @var Layout
     */
    protected $layout;
    /**
     * Constructeur
     * @param Request $request
     * @param Response $response
     */
    public $form;

    public function __construct(Request $request, Response $response,$layout,$view)
    {
        $this->request = $request;
        $this->response = $response;  
        $this->view = new View($view); 
        $this->layout = new Layout($this->view,$layout);
        $this->Session = new Session();
        $this->view->session = $this->Session;
      //  $this->form = new Form($this);
    }
    

    public function index()
    {

    }

    /**
    * Permet de charger un model
    **/
    public function loadModel($name,$form=null)
    {
        if(!isset($this->$name)){
            $file = MODEL_PATH . DS .$name.'.php'; 
            require_once($file);
            $this->$name = new $name();
            //if(isset($this->form)){
               // $this->$name->form = $this->form;  
            //}
            if(isset($form)){
            $this->$name->form = new Form();
            $this->$name->form->data = $this->request->data;
            }
        }

    }
    public function redirect($url)
    {
        print ("<script language = \"JavaScript\">");
        print ("location.href = '$url';");
        print ("</script>");
    }
    public function __destruct()
    {
        $viewContent = $this->layout->render();
        $this->response->setBody($viewContent);
    }
}