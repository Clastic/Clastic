<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\NodeBundle\Filter;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationFilter extends SQLFilter
{
    private $applyPublication = true;

    /**
     * {@inheritdoc}
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (!$this->applyPublication) {
            return '';
        }

        if (!$targetEntity->reflClass->implementsInterface(NodeReferenceInterface::class)) {
            return '';
        }

        $joinSql = 'SELECT COUNT(n_n.id) FROM Node n_n JOIN NodePublication n_np ON n_n.publication_id = n_np.id';

        $filterSql = 'n_np.available = 1'
            .' AND (n_np.publishedFrom > NOW() OR n_np.publishedFrom IS NULL)'
            .' AND (n_np.publishedTill < NOW() OR n_np.publishedTill IS NULL)'
        ;

        return sprintf('(%s WHERE n_n.id = %s.node_id AND (%s)) = 1', $joinSql, $targetTableAlias, $filterSql);
    }

    /**
     * @param bool $applyPublication
     */
    public function setApplyPublication($applyPublication)
    {
        $this->applyPublication = $applyPublication;
    }
}
