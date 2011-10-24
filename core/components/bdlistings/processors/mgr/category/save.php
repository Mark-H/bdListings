<?php
/* @var modX $modx
 * @var array $scriptProperties
 * @var bdlCategory $category
 */

$id = (int)$modx->getOption('id',$scriptProperties,null);

if ($id > 0) {
    $category = $modx->getObject('bdlCategory',$id);
    if (!($category instanceof bdlCategory))
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
} else {
    $category = $modx->newObject('bdlCategory');
}

$d = $scriptProperties;

$category->fromArray($d);

$result = $category->save();

if (!$result) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.save'));
}

return $modx->error->success();

?>