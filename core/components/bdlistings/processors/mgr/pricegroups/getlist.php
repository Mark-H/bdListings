<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'sortorder');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$c = $modx->newQuery('bdlPriceGroup');

$matches = $modx->getCount('bdlPriceGroup',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();

$r = $modx->getCollection('bdlPriceGroup',$c);
foreach ($r as $target) {
    /* @var bdlPriceGroup $target */
    $ta = $target->toArray();
    $results[] = $ta;
}

if (count($results) == 0) {
    return $modx->error->failure($modx->lexicon('bdlistings.error.noresults'));
}
$ra = array(
    'success' => true,
    'total' => $matches,
    'results' => $results
);

return $modx->toJSON($ra);