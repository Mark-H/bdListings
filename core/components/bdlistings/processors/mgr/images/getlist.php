<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'sortorder');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$listing = $modx->getOption('listing',$scriptProperties,0);

$c = $modx->newQuery('bdlImage');

if ($listing > 0) $c->where(array('listing' => (int)$listing));

$matches = $modx->getCount('bdlImage',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();

$r = $modx->getCollection('bdlImage',$c);
foreach ($r as $target) {
    /* @var bdlImage $target */
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