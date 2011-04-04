<?php
require_once 'AbstractControllerTestCase.php';

class SitemapControllerTest extends AbstractControllerTestCase
{
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $navigation = new Zend_Navigation(array(
            array(
                'type' => 'Mvc',
                'label' => 'First page',
                'action' => 'index',
                'controller' => 'index',
                'module' => 'default'
            ),
            array(
                'type' => 'Uri',
                'label' => 'Second page',
                'uri' => 'http://www.maitre-corbeaux.com/'
            )
        ));

        $view = $this->bootstrap->getBootstrap()
                                ->getResource('View');

        // We replace Navigation with a sample one for test purpose
        $helper = $view->getHelper('Navigation');
        $helper->setContainer($navigation);

        $sitemap = $helper->sitemap();
        // We define the server url, because in Test environment there is no HTTP Host
        $sitemap->setServerUrl('http://www.maitre-corbeaux.com');
        // We disable Xml Declaration, it seems that assertQuery doesn't work with XML content
        $sitemap->setUseXmlDeclaration(false);
    }

    public function testIndexActionIsReachable()
    {
        $this->dispatch('/sitemap.xml');

        $this->assertModule('default');
        $this->assertController('sitemap');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }

    public function testIndexActionContentTypeIsTextXml()
    {
        $this->dispatch('/sitemap.xml');
        $this->assertHeader('Content-Type', 'text/xml');
    }

    public function testIndexActionRenderSitemapWithOnlyMvcRoutes()
    {
        $this->dispatch('/sitemap.xml');
        $this->assertQueryCount('urlset', 1);
        $this->assertQueryCount('url', 1);
    }
}