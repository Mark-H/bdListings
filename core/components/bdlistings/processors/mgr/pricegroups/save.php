<?php
/* @var modX $modx
 * @var array $scriptProperties
 * @var bdlPriceGroup $target
 */

$id = (int)$modx->getOption('id',$scriptProperties,null);

if ($id > 0) {
    $target = $modx->getObject('bdlPriceGroup',$id);
    if (!($target instanceof bdlPriceGroup))
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
} else {
    $target = $modx->newObject('bdlPriceGroup');
}

$d = $scriptProperties;

$target->fromArray($d);

$result = $target->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>