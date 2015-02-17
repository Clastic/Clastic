<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\TaxonomyBundle\EventListener;

use Clastic\NewsBundle\Entity\Category;
use Clastic\NodeBundle\Event\NodeFormPersistEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * NodeListener
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class NodeFormPersistListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            NodeFormPersistEvent::NODE_FORM_PERSIST => 'saveCategoryTree',
        );
    }

    /**
     * @param NodeFormPersistEvent $event
     *
     * @throws \Exception
     */
    public function saveCategoryTree(NodeFormPersistEvent $event)
    {
        if (! $event->getForm()->getData() instanceof Category) {
            return;
        }

        $positionData = $event->getForm()->get('tabs')->get('general')->get('position')->getNormData();

        if ($positionData) {
            $entityName = 'ClasticNewsBundle:Category';
            $positionData = json_decode($positionData);
            $data = $event->getForm()->getData();

            $em = $event->getEm();
            $repo = $em->getRepository($entityName);

            $positionData->parent = intval($positionData->parent) ? ($positionData->parent) : 0;

            if (intval($positionData->parent) > 0) {
                $data->setParent($em->getReference($entityName, $positionData->parent));
            } else {
                $data->setParent(null);
            }

            $repo->persistAsFirstChild($data);
            if ($positionData->position) {
                $repo->moveDown($data, $positionData->position);
            }

            $em->flush();
        }
    }
}
