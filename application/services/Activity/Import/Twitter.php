<?php
/**
 * Import Activity Items from Twitter RSS feed
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_Activity_Import_Rss
 */
class MaitreCorbeaux_Service_Activity_Import_Twitter
extends MaitreCorbeaux_Service_Activity_Import_Rss
{
    /**
     *
     * @var string
     */
    protected $_feedUrl = 'http://twitter.com/statuses/user_timeline/79409884.rss';
}