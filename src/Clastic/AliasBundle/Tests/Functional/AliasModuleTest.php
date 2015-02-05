<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Tests\Controller;

use Clastic\BackofficeBundle\Tests\AuthenticatedWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class AliasModuleTest extends AuthenticatedWebTestCase
{
    protected $listUrl = '/admin/alias/list';
    protected $newUrl = '/admin/alias/edit';

    public function testInMenu()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            1,
            $crawler->filter('nav li a:contains("Alias")')->count()
        );

        $a = $crawler->filter('nav li a:contains("Alias")');
        $this->assertEquals($this->listUrl, $a->attr('href'));
    }

    public function testList()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(
            1,
            $crawler->filter('nav li a:contains("Alias")')->count()
        );
    }

    /**
     * New form is not implemented yet.
     */
    public function testNoNewForm()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', $this->newUrl);

        $this->assertFalse($client->getResponse()->isSuccessful());
    }
}
