<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\CoreBundle;

/**
 * NodeEvents.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
final class NodeEvents
{
    const CREATE = 'clastic.node.create';
    const RESOLVE_ENTITY_NAME = 'clastic.node.resolve_entity_name';
}
