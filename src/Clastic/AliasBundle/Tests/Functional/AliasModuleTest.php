<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\Tests\Functional;

use Clastic\BackofficeBundle\Tests\ModuleWebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
 */
class AliasModuleTest extends ModuleWebTestCase
{
    protected $listUrl = '/admin/alias/list';
    protected $newUrl = '/admin/alias/edit';

    /**
     * New form is not implemented yet.
     */
    public function testNoNewForm()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', $this->newUrl);

        $this->assertFalse($client->getResponse()->isSuccessful(), "Request should failed");
    }

    public function testListNoAddButton()
    {
        $client = $this->createAuthorizedClient();
        $crawler = $client->request('GET', $this->listUrl);

        $this->assertTrue($client->getResponse()->isSuccessful(), "Request failed");
        $this->assertEquals(
            0,
            $crawler->filter('h1 a')->count()
        );
        $this->assertEquals(
            0,
            $crawler->filter(sprintf('a[href="%s"]', $this->newUrl))->count()
        );
    }

    public function testNoAddForm()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', $this->newUrl);

        $this->assertFalse($client->getResponse()->isSuccessful(), "Request should failed");
    }
}
