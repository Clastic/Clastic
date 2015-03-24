<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\BackofficeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * HTMLPurifierTransformer
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class SanitizerTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        $purifier = new \HTMLPurifier(\HTMLPurifier_Config::createDefault());

        return $purifier->purify($value);
    }
}
