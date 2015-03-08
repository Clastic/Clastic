<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\NewsBundle\Tests\Controller;

use Clastic\BackofficeBundle\Tests\AuthenticatedWebTestCase;

/**
 * NewsCategoryModuleTest
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class NewsTagModuleTest extends AuthenticatedWebTestCase
{
    protected $listUrl = '/admin/news/tag/list';
    protected $formUrl = '/admin/news/tag/edit';

    public function testNotInMenu()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(0, $crawler->filter('nav li a:contains("Tag")')->count());
    }

    public function testList()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
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
