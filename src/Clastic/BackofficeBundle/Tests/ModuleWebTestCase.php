<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BackofficeBundle\Tests;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class ModuleWebTestCase extends AuthenticatedWebTestCase
{
    /**
     * Test if the link is available in the menu.
     */
    public function testInMenu()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request failed');
        $this->assertEquals(1, $crawler->filter('nav li a[href="'.$this->listUrl.'"]')->count());
    }

    /**
     * Test if the list page works.
     */
    public function testList()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request failed');
        $this->assertEquals(1, $crawler->filter('nav li a[href="'.$this->listUrl.'"]')->count());
    }

    /**
     * Test if a form is found.
     */
    public function testForm()
    {
        if (!isset($this->formUrl)) {
            return;
        }

        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->formUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'Request failed');
        $this->assertGreaterThan(0, $crawler->filter('form')->count());
    }
}
