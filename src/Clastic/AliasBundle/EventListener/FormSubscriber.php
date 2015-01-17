<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\AliasBundle\EventListener;

use Clastic\AliasBundle\Entity\Alias;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Validator\ViolationMapper\ViolationMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 * NodeListener
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class FormSubscriber implements EventSubscriberInterface
{
    /**
     * @var RecursiveValidator
     */
    private $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SUBMIT => 'validate',
        );
    }

    /**
     * Validate if the Alias is valid and unique.
     *
     * @param FormEvent $event
     */
    public function validate(FormEvent $event)
    {
        /** @var Alias $alias */
        $alias = $event->getData()->getNode()->alias;

        $violations = $this->validator->validate($alias);

        if (!$violations) {
            return;
        }

        $mapper = new ViolationMapper();
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $mapper->mapViolation($violation, $event->getForm(), true);
        }
    }
}
