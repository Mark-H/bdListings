<?php

$periodLength = (int)$modx->getOption('periodlength',$scriptProperties,259200); /* Default: 3 days */
$periodAmount = (int)$modx->getOption('periodamount',$scriptProperties,10);
$periodEnd = $modx->getOption('periodend',$scriptProperties,time());
if (!is_numeric($periodEnd)) $periodEnd = strtotime($periodEnd);
$periodStart = $periodEnd - ($periodAmount * $periodLength);

$periods = array();
$results = array();
$period = $periodAmount;
while ($period > 0) {
    $c = $modx->newQuery('bdlClicks');
    $start = $periodStart + ($period * $periodLength);
    $end = $start + $periodLength;
    $c->where(
        array(
            'clicktime:>' => date('Y-m-d H:i:s',$start),
            'AND:clicktime:<' => date('Y-m-d H:i:s',$end)
        )
    );
    $count = $modx->getCount('bdlClicks',$c);
    $results[] = array(
        'period' => date($modx->config['manager_date_format'],$end),
        'clicks' => $count
    );
    $period = $period - 1;
}

$results = array_reverse($results);

$ra = array(
    'success' => true,
    'results' => $results
);

return $modx->toJSON($ra);