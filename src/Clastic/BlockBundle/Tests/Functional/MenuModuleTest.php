<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlockBundle\Tests\Controller;

use Clastic\BackofficeBundle\Tests\AuthenticatedWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class BlockModuleTest extends AuthenticatedWebTestCase
{
    protected $listUrl = '/admin/block/list';
    protected $formUrl = '/admin/block/edit';

    public function testInMenu()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(1, $crawler->filter('nav li a:contains("Block")')->count());

        $a = $crawler->filter('nav li a:contains("Block")');
        $this->assertEquals($this->listUrl, $a->attr('href'));
    }

    public function testList()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(1, $crawler->filter('nav li a:contains("Block")')->count());
        $this->assertGreaterThan(0, $crawler->filter('table')->count());
    }

    public function testForm()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->formUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertGreaterThan(0, $crawler->filter('form')->count());
    }
}
