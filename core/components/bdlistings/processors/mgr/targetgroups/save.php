<?php
/* @var modX $modx
 * @var array $scriptProperties
 * @var bdlTarget $target
 */

$id = (int)$modx->getOption('id',$scriptProperties,null);

if ($id > 0) {
    $target = $modx->getObject('bdlTarget',$id);
    if (!($target instanceof bdlTarget))
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
} else {
    $target = $modx->newObject('bdlTarget');
}

$d = $scriptProperties;

$target->fromArray($d);

$result = $target->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>