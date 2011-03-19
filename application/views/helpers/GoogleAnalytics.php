<?php
/**
 * Google Analytics view helper
 * Render a traditional or asynchronous Google Analytics snippet
 * 
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package View
 * @subpackage Helper
 * @see Zend_View_Helper_Abstract
 */
class MaitreCorbeaux_View_Helper_GoogleAnalytics
extends Zend_View_Helper_Abstract
{
    const MODE_ASYNCHRONOUS = 'asynchronous';
    const MODE_TRADITIONAL = 'traditional';
    
    /**
     * Google Analytics account's Id
     *
     * @var string
     */
    protected $_accountId;
    
    /**
     * Google Analytics snippet type
     * Can be traditional or asynchronous
     *
     * @var string
     */
    protected $_mode;

    /**
     * 
     * @param string $accountId
     * @param string $mode
     * @return MaitreCorbeaux_View_Helper_GoogleAnalytics
     */
    public function googleAnalytics($accountId = null, $mode = null)
    {
        if (null !== $accountId) {
            $this->setAccountId($accountId);
        }

        if (null !== $mode) {
            $this->setMode($mode);
        }

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->_accountId;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_View_Helper_GoogleAnalytics
     */
    public function setAccountId($value)
    {
        $this->_accountId = (string) $value;
    }
    
    /**
     *
     * @return string
     */
    public function getMode()
    {
        return $this->_mode;
    }

    /**
     * 
     * @param string $value
     * @return MaitreCorbeaux_View_Helper_GoogleAnalytics
     */
    public function setMode($value)
    {
        $this->_mode = (string) $value;
    }

    /**
     * String conversion
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Render the Google Analytics snipper
     * depending on the snippet mode selected
     *
     * @throws MaitreCorbeaux_View_Helper_Exception
     * @return string HTML snippet
     */
    public function render()
    {
        if (empty($this->_mode)) {
            throw new MaitreCorbeaux_View_Helper_Exception("Snippet mode can't be empty");
        }

        switch ($this->_mode) {
            case self::MODE_TRADITIONAL:
                return $this->_renderTraditional();
                break;

            case self::MODE_ASYNCHRONOUS:
                return $this->_renderAsynchronous();
                break;

            default:
                throw new MaitreCorbeaux_View_Helper_Exception('Unknown snippet mode : "' . $this->_mode . '"');
                break;
        }
    }

    /**
     * Render the asynchronous snippet
     *
     * @return string Asynchronous HTML snippet
     */
    protected function _renderAsynchronous()
    {
        $accountId = $this->view->escape($this->getAccountId());
        $javascript = <<< EOF
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$accountId']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
EOF;

        return $javascript;
    }

    /**
     * Render the traditional snippet
     *
     * @return string Traditional HTML snippet
     */
    protected function _renderTraditional()
    {
        $accountId = $this->view->escape($this->getAccountId());
        $javascript = <<< EOF
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("$accountId");
pageTracker._trackPageview();
} catch(err) {}</script>
EOF;

        return $javascript;
    }
}
