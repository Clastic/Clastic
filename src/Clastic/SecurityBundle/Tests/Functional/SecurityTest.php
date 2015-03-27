<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\SecurityeBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 *
 * @group functional
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

    public function testLoginForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/login');

        $this->assertEquals(1, $crawler->filter('form')->count());
        $this->assertEquals(1, $crawler->filter('form input[name="_username"]')->count());
        $this->assertEquals(1, $crawler->filter('form input[name="_password"]')->count());
        $this->assertEquals(1, $crawler->filter('form input[name="_remember_me"]')->count());
        $this->assertEquals(1, $crawler->filter('form button[name="_submit"]')->count());
    }
}
