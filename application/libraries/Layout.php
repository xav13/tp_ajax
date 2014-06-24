<?php 

/**
 * Objet Layout
 * 
 * Permet d'afficher un gabarit autour des vues
 * 
 * @Category IPLIB
 * @author Formateur
 *@version 0.0.1
 *
 */
class Layout
{
    /**
     * @var string
     */
    private $file;
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @var View
     */
    private $view;
    
    public function __construct($view,$layout='torrefaction.phtml')
    {
        $this->file = LAYOUT_PATH . DS . $layout;
        $this->view = $view;
    }
    
    public function render()
    {
        $this->content = $this->view->render();
        ob_start();
        require $this->file;
        return ob_get_clean();
    }
}