<?php
/* @var array $scriptProperties
 * @var modX $modx
 */
$d = $scriptProperties;
if ($d['id']) {

    /* @var bdlCategory $cat */
    $cat = $modx->getObject('bdlCategory',$d['id']);

    if (!($cat instanceof bdlCategory)) {
        return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));
    }

    $data = $cat->toArray();
    return $modx->error->success('',$data);
}
return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));