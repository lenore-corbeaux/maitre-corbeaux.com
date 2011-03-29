<?php
/**
 * Class for importing Activity Item from Atom feed
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_Activity_Import_Feed
 */
class MaitreCorbeaux_Service_Activity_Import_Atom
extends MaitreCorbeaux_Service_Activity_Import_Feed
{
    /**
     *
     * @param Zend_Feed_Entry_Abstract $item
     * @return MaitreCorbeaux_Model_Activity_Item
     * @see MaitreCorbeaux_Service_Activity_Import_Feed::_createActivityItem()
     */
    protected function _createActivityItem(Zend_Feed_Entry_Abstract $item)
    {
        $publicationDate = new Zend_Date($item->published, Zend_Date::RFC_3339);
        // We restores default timezone, as we don't want the RSS timezone to be used
        $publicationDate->setTimezone();
        
        $data = array(
            'title' => $item->title(),
            'description' => $item->content(),
            'link' => $item->link('alternate'),
            'externalId' => $item->id(),
            'publicationDate' => $publicationDate
        );
        
        if (mb_strlen($data['description']) > 255) {
            $data['description'] = mb_substr($data['description'], 0, 252)
                                 . '...';
        }

        return new MaitreCorbeaux_Model_Activity_Item($data);
    }

}