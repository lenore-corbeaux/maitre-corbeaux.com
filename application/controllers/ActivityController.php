<?php
/**
 * Activity Controller
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Controller
 * @see Zend_Controller_Action
 */
class ActivityController extends Zend_Controller_Action
{
    /**
     * Initialize static cache
     *
     * @return void
     */
    public function init()
    {
        $this->_helper->cache(array('index'), array('activity'));
    }
    
    /**
     * Display the activity page : All Activity Items paginated
     */
    public function indexAction()
    {
        $this->view
             ->headTitle(
                'Activité Internet de Lucas Corbeaux, développeur senior sur Angers',
                'PREPEND'
             );
        
        $page = $this->_getParam('page');
        
        if ($this->_hasParam('query')) {
            $query = $this->_getParam('query');
            $service = new MaitreCorbeaux_Service_Activity_Search();
            $this->view->paginator = $service->searchItems($query, $page);
            $this->view->query = $query;
        } else {
            $service = new MaitreCorbeaux_Service_Activity_Item();
            $this->view->paginator = $service->paginateAll($page);
        }
    }
}

