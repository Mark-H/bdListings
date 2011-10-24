<?php
/* @var bdlCategory $object
 * @var modX $modx
 * @var array $scriptProperties
 */

$id = (int)$modx->getOption('id',$scriptProperties);
if ($id < 1) return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));

$object = $modx->getObject('bdlCategory',$id);
if (!($object instanceof bdlCategory)) return $modx->error->failure($modx->lexicon('bdlistings.error.object_nf'));

if ($object->remove())
    return $modx->error->success();
return $modx->error->failure($modx->lexicon('bdlistings.error.remove'));
?>
