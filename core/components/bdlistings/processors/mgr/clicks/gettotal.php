<?php

$periodEnd = $modx->getOption('periodend',$scriptProperties);
if (!empty($periodEnd)) $periodEnd = strtotime($periodEnd);
else $periodEnd = time();
$periodEnd = ceil($periodEnd);

$periodStart = $modx->getOption('periodstart',$scriptProperties);
if (!empty($periodStart)) $periodStart = strtotime($periodStart);

$periodLength = 86400;

if (!empty($periodStart)) {
    $periodAmount = ceil(($periodEnd - $periodStart) / $periodLength);
} else {
    $periodAmount = 31;
    $periodStart = $periodEnd - ($periodLength * 31);
}
$periodStart = ceil($periodStart);

$listing = (int)$modx->getOption('listing',$scriptProperties);

$results = array();
$period = 0;
while ($period < $periodAmount) {
    $c = $modx->newQuery('bdlClicks');
    $start = $periodStart + ($period * $periodLength);
    $end = $start + $periodLength;
    $c->where(
        array(
            'clicktime:>' => date('Y-m-d H:i:s',$start),
            'AND:clicktime:<' => date('Y-m-d H:i:s',$end)
        )
    );
    if ($listing) $c->where(array('listing' => $listing));
    $count = $modx->getCount('bdlClicks',$c);
    $p = date($modx->config['manager_date_format'],$start);
    $results[] = array(
        'period' => $p,
        'clicks' => $count
    );
    $period++;
}

$ra = array(
    'success' => true,
    'results' => $results,
    'vars' => array(
        'start' => $periodStart,
        'end' => $periodEnd,
        'amount' => $periodAmount
    )
);

return $modx->toJSON($ra);