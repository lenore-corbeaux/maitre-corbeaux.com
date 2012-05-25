<?php
/**
 * Import Activity Items from Pocket API
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface
 */
class MaitreCorbeaux_Service_Activity_Import_Pocket
extends MaitreCorbeaux_Service_AbstractService
implements MaitreCorbeaux_Service_Activity_Import_ImportInterface
{
    /**
     * Base url for the get method of the Pocket API
     *
     * @var string
     */
    const POCKET_API_URL = 'https://getpocket.com/v2/get';
    
    /**
     * Pocket API read state
     *
     * @var string
     */
    const POCKET_API_STATE_READ = 'read';
    
    /**
     * Http client used to query the Pocket API.
     * 
     * @var Zend_Http_Client
     */
    protected $_httpClient;
    
    /**
     * Getter for HTTP client
     * 
     * @return Zend_Http_Client
     */
    public function getHttpClient()
    {
        if (null === $this->_httpClient) {
            $this->_httpClient = new Zend_Http_Client();
        }
        
        return $this->_httpClient;
    }
    
    /**
     * Setter for HTTP client
     * 
     * @param Zend_Http_Client $httpClient
     * @return MaitreCorbeaux_Service_Activity_Import_Pocket
     */
    public function setHttpClient(Zend_Http_Client $httpClient)
    {
        $this->_httpClient = $httpClient;
        return $this;
    }
    
    /**
     * Import Activity Items
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface::import()
     * @throws MaitreCorbeaux_Service_Activity_Import_Exception
     */
    public function import()
    {
        $options = $this->getBootstrap()
                        ->getOption('pocket');

        if (!isset($options['username'])) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
            'Pocket API username is required'
            );
        }
        
        if (!isset($options['password'])) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Pocket API password is required'
            );
        }

        if (!isset($options['apikey'])) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Pocket API key is required'
            );
        }
        
        $httpClient = $this->getHttpClient();
        $httpClient->setUri(self::POCKET_API_URL)
                   ->setParameterPost('username', $options['username'])
                   ->setParameterPost('password', $options['password'])
                   ->setParameterPost('apikey', $options['apikey'])
                   ->setParameterPost('state', self::POCKET_API_STATE_READ);
        
        $response = $httpClient->request('POST');
        
        if (!$response->isSuccessful()) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Error while querying Pocket API'
            );
        }
        
        $jsonData = $response->getBody();
        
        $data = Zend_Json::decode($jsonData);
        
        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();
        
        if (!isset($data['list'])) {
            return $collection;
        }
        
        foreach ($data['list'] as $itemData) {
            $collection->add($this->_createActivityItem($itemData));
        }
        
        return $collection;
    }
    
    /**
     * Retourne un modèle ActivityItem à partir des données de l'API
     * 
     * @param array $data
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    protected function _createActivityItem(array $data)
    {
        $publicationDate = new Zend_Date($data['time_updated']);
        $title = 'Je viens de lire : ' . $data['title'];
        
        $model = new MaitreCorbeaux_Model_Activity_Item(array(
            'title' => $title,
            'description' => $title,
            'link' => $data['url'],
            'externalId' => $data['item_id'],
            'publicationDate' => $publicationDate
        ));
        
        return $model;
    }
}
