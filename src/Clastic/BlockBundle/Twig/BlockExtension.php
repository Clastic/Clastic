<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BlockBundle\Twig;

use Clastic\BlockBundle\Block\BlockManager;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlockExtension extends \Twig_Extension
{
    /**
     * @var BlockManager
     */
    private $blockManager;

    /**
     * @param BlockManager $blockManager
     */
    public function __construct(BlockManager $blockManager)
    {
        $this->blockManager = $blockManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('clastic_block', array($this, 'renderBlock'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param string $identifier
     *
     * @return string
     */
    public function renderBlock($identifier)
    {
        return $this->blockManager->get($identifier)->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'clastic_block';
    }
}
