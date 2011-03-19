<?php
/**
 * Test class for MaitreCorbeaux_View_Helper_GoogleAnalytics
 * 
 */
class MaitreCorbeaux_View_Helper_TestGoogleAnalytics
extends PHPUnit_Framework_TestCase
{
    /**
     * GoogleAnalytics Helper
     * 
     * @var MaitreCorbeaux_View_Helper_GoogleAnalytics
     */
    protected $_helper;
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $application = new Zend_Application(APPLICATION_ENV,
                                            APPLICATION_PATH
                                            . '/configs/application.ini');

        $bootstrap = $application->getBootstrap();
        $bootstrap->bootstrap('view');
        $view = $bootstrap->getResource('View');

        $this->_helper = $view->getHelper('GoogleAnalytics');
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_helper);
    }

    public function testPropertiesAreEmpty()
    {
        $this->assertNull($this->_helper->getAccountId());
        $this->assertNull($this->_helper->getMode());
    }

    public function testGoogleAnalyticsReturnsObjectInstance()
    {
        $this->assertSame($this->_helper, $this->_helper->googleAnalytics());
    }

    public function testRenderAsynchronousEscapesAccountId()
    {
        $accountId = '<br/>';
        $mode = MaitreCorbeaux_View_Helper_GoogleAnalytics::MODE_ASYNCHRONOUS;
        $expectedId = $this->_helper->view
                                    ->escape($accountId);

        $expected = <<< EOF
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '$expectedId']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
EOF;
        $actual = (string) $this->_helper->googleAnalytics($accountId, $mode);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderTraditionalEscapesAccountId()
    {
        $accountId = '<br/>';
        $mode = MaitreCorbeaux_View_Helper_GoogleAnalytics::MODE_TRADITIONAL;
        $expectedId = $this->_helper->view
                                    ->escape($accountId);

        $expected = <<< EOF
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("$expectedId");
pageTracker._trackPageview();
} catch(err) {}</script>
EOF;
        $actual = (string) $this->_helper->googleAnalytics($accountId, $mode);
        $this->assertEquals($expected, $actual);
    }

    public function testRenderThrowsExceptionWithEmptyMode()
    {
        $this->setExpectedException('MaitreCorbeaux_View_Exception');
        $this->_helper->googleAnalytics('anId')
                      ->render();
    }

    public function testRenderThrowsExceptionWithUnknownMode()
    {
        $this->setExpectedException('MaitreCorbeaux_View_Exception');
        $this->_helper->googleAnalytics('anId', 'unknowMode')
                      ->render();
    }
}