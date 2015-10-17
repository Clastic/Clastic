<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\BlockBundle\Block;

use Clastic\BlockBundle\Entity\Block;
use Clastic\BlockBundle\Entity\BlockRepository;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class BlockManager
{
    /**
     * @var BlockRepository
     */
    private $repo;

    /**
     * @param BlockRepository $repo
     */
    public function __construct(BlockRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param string $identifier
     *
     * @return Block
     */
    public function get($identifier)
    {
        $block = $this->repo->findOneBy(array(
            'identifier' => $identifier,
        ));

        return $block;
    }
}
