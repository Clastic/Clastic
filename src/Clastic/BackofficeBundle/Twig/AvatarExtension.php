<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Twig;

use Symfony\Component\Security\Core\SecurityContext;
use thomaswelton\GravatarLib\Gravatar;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class AvatarExtension extends \Twig_Extension
{
    /**
     * @param SecurityContext $context
     */
    public function __construct(SecurityContext $context)
    {
        $this->context = $context;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'clastic_backoffice_avatar';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('avatar', array($this, 'buildAvatar')),
        );
    }

    /**
     * Get the email from the user logged in.
     *
     * @return string
     */
    public function getUserEmail()
    {
        $token = $this->context->getToken();

        if (!$token) {
            return null;
        }

        return $token->getUser()->getEmail();
    }

    /**
     * Get the img path for the gravatar of the current user.
     *
     * @param int $size
     *
     * @return string
     */
    public function buildAvatar($size = 150)
    {
        $gravatar = new Gravatar();
        $gravatar->setAvatarSize($size);

        return $gravatar->buildGravatarURL($this->getUserEmail());
    }
}
