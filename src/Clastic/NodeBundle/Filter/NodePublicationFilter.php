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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodePublicationFilter extends SQLFilter
{
    /**
     * @var bool
     */
    private $applyPublication = true;

    /**
     * @var array
     */
    private $tableNames = [];
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

        $joinSql = sprintf(
            'SELECT COUNT(n_n.id) FROM %s n_n JOIN %s n_np ON n_n.publication_id = n_np.id',
            $this->resolveTableName('ClasticNodeBundle:Node'),
            $this->resolveTableName('ClasticNodeBundle:NodePublication')
        );

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

    /**
     * @param string $name
     * @return string
     */
    private function resolveTableName($name)
    {
        if (isset($this->tableNames[$name])) {
            return $this->tableNames[$name];
        }

        $ref = new \ReflectionProperty(parent::class, 'em');
        $ref->setAccessible(true);

        /** @var EntityManager $em */
        $em = $ref->getValue($this);

        return $this->tableNames[$name] = $em->getClassMetadata($name)->getTableName();
    }
}
