<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as FOSProfileController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ProfileController extends FOSProfileController
{
    public function showAction()
    {
        $this->buildBreadcrumbs('user');

        return parent::showAction();
    }

    /**
     * @param string $type
     *
     * @return Breadcrumbs
     */
    protected function buildBreadcrumbs($type)
    {
        /** @var Breadcrumbs $breadcrumbs */
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("clastic_backoffice_dashboard"));

        /** @var NodeModuleInterface $module */
        $module = $this->get('clastic.module_manager')->getModule($type);
        if ($module) {
            $breadcrumbs->addItem($module->getName(), $this->get("router")->generate("clastic_node_list", array(
                'type' => $type,
            )));
        }

        return $breadcrumbs;
    }

}
