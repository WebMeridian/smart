<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Admin configuration model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Smart_Customflatrate_Model_Core_Config  extends Mage_Core_Model_Config
{


    public function loadModulesConfiguration($fileName, $mergeToObject = null, $mergeModel=null)
    {
        $disableLocalModules = !$this->_canUseLocalModules();

        if ($mergeToObject === null) {
            $mergeToObject = clone $this->_prototype;
            $mergeToObject->loadString('<config/>');
        }
        if ($mergeModel === null) {
            $mergeModel = clone $this->_prototype;
        }
        $modules = $this->getNode('modules')->children();
        foreach ($modules as $modName=>$module) {
            if ($module->is('active')) {
                if ($disableLocalModules && ('local' === (string)$module->codePool)) {
                    continue;
                }
                if (!is_array($fileName)) {
                    $fileName = array($fileName);
                }

                foreach ($fileName as $configFile) {
                    //if($modName == 'Smart_CustomFlatrate') continue;
                    print '111<br>';
                    $configFile = $this->getModuleDir('etc', $modName).DS.$configFile;
                    if ($mergeModel->loadFile($configFile)) {
                        $mergeToObject->extend($mergeModel, true);
                    }
                }
            }
        }
        return $mergeToObject;
    }

    
}
