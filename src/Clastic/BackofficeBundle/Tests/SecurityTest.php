<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SecurityTest extends WebTestCase
{
    public function testLoginRedirect()
    {
        $client = static::createClient();
        $client->request('GET', '/admin/');

        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertRegExp('|/admin/login$|', $client->getResponse()->headers->get('location'));
    }
}
