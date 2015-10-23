<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\GeneratorBundle\Command;

/**
 * Validators.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Validators extends \Sensio\Bundle\GeneratorBundle\Command\Validators
{
    public static function validateModuleName($module)
    {
        if (!preg_match('/Module/', $module)) {
            throw new \InvalidArgumentException('The module name must end with Module.');
        }

        try {
            self::validateEntityName($module);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The module name must contain a : ("%s" given, expecting something like AcmeBlogBundle:PostModule)',
                    $module
                )
            );
        }

        return $module;
    }
}
