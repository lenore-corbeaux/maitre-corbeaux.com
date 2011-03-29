<?php
/**
 * Import Activity Items from Developpez.com blog RSS feed
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_Activity_Import_Rss
 */
class MaitreCorbeaux_Service_Activity_Import_DeveloppezCom
extends MaitreCorbeaux_Service_Activity_Import_Rss
{
    /**
     *
     * @var string
     */
    protected $_feedUrl = 'http://blog.developpez.com/xmlsrv/rss2.php?blog=331';
}