<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlogBundle\Tests\Controller;

use Clastic\BackofficeBundle\Tests\AuthenticatedWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class BlogModuleTest extends AuthenticatedWebTestCase
{
    protected $listUrl = '/admin/blog/list';
    protected $formUrl = '/admin/blog/edit';

    public function testInMenu()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(1, $crawler->filter('nav li a:contains("Blog")')->count());

        $a = $crawler->filter('nav li a:contains("Blog")');
        $this->assertEquals($this->listUrl, $a->attr('href'));
    }

    public function testList()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(1, $crawler->filter('nav li a:contains("Blog")')->count());
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
