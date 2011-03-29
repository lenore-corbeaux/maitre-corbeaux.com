<?php
/**
 * Import Activity Items from Github Atom feed
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_Activity_Import_Atom
 */
class MaitreCorbeaux_Service_Activity_Import_Github
extends MaitreCorbeaux_Service_Activity_Import_Atom
{
    /**
     *
     * @var string
     */
    protected $_feedUrl = 'https://github.com/lucascorbeaux.atom';
}