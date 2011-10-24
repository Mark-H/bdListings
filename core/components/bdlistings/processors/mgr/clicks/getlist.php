<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'clicktime');
$dir = $modx->getOption('dir',$scriptProperties,'DESC');

$dateStart = $modx->getOption('date-start',$scriptProperties);
$dateEnd = $modx->getOption('date-end',$scriptProperties);
$listing = $modx->getOption('listing',$scriptProperties);

$c = $modx->newQuery('bdlClicks');
$c->leftJoin('bdlListing','Listing');
$c->select(
    array(
        'bdlClicks.*',
        'listing_title' => '`Listing`.`title`',
    )
);

if ($listing) $c->where(array('listing' => $listing));
if ($dateStart) {
    $dateStart = date('Y-m-d H:i:s',strtotime($dateStart));
    $c->where(array('clicktime:>' => $dateStart));
}
if (!empty($dateEnd)) {
    $dateEnd = date('Y-m-d H:i:s',strtotime($dateEnd));
    $c->where(array('clicktime:<' => $dateEnd));
}

$matches = $modx->getCount('bdlClicks',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();

$r = $modx->getCollection('bdlClicks',$c);
foreach ($r as $click) {
    /* @var bdlClicks $click */
    $ta = $click->toArray('',false,true);
    $ta['clicktime'] = date($modx->config['manager_date_format'].' '.$modx->config['manager_time_format'],strtotime($ta['clicktime']));
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