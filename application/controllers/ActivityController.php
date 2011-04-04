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
        $service = new MaitreCorbeaux_Service_Activity_Item();
        $this->view->paginator = $service->paginateAll($page);
    }
}

