<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/').'model/';
            $modx->addPackage('bdlistings',$modelPath);

            $manager = $modx->getManager();
            $modx->log(xPDO::LOG_LEVEL_WARN,'Making database changes - if this is a clean install or you have run this installer before you may get some (harmless) errors below.');
            $manager->addField('bdlListing','views');
            $manager->alterField('bdlListing','featured');

            break;
    }
}
return true;
?>
