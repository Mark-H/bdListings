<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,20);
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'asc');

$search = $modx->getOption('query',$scriptProperties,null);
$target = $modx->getOption('target',$scriptProperties,null);
$pricegroup = $modx->getOption('pricegroup',$scriptProperties,null);

$c = $modx->newQuery('bdlListing');
$c->leftJoin('bdlCategory','Category');
$c->leftJoin('bdlCategory','SubCategory');
$c->leftJoin('bdlTarget','Target');
$c->leftJoin('bdlPriceGroup','PriceGroup');
$c->select(
    array(
        'bdlListing.*',
        'category_name' => 'Category.name',
        'subcategory_name' => 'SubCategory.name',
        'target_name' => 'Target.name',
        'pricegroup_display' => 'PriceGroup.display',
    )
);

if ($search) {
    $c->where(
        array(
            'title:LIKE' => "%$search%",
            'OR:description:LIKE' => "%$search%",
            'OR:keywords:LIKE' => "%$search%",
            'OR:companyname:LIKE' => "%$search%",
            'OR:address:LIKE' => "%$search%",
        )
    );
    if (is_numeric($search))
        $c->orCondition(array('id' => (int)$search));
}
if (is_numeric($target)) {
    $target = (int)$target;
    $c->andCondition(array('target' => $target));
}
if (is_numeric($pricegroup)) {
    $pricegroup = (int)$pricegroup;
    $c->andCondition(array('pricegroup' => $pricegroup));
}

$matches = $modx->getCount('bdlListing',$c);

$c->sortby($sort,$dir);
$c->limit($limit,$start);

$results = array();

$r = $modx->getCollection('bdlListing',$c);
foreach ($r as $listing) {
    /* @var bdlListing $listing */
    $ta = $listing->toArray('',false,true);
    $ta['createdon'] = ($ta['createdon'] != '0000-00-00 00:00:00') ? date($modx->config['manager_date_format'].' '.$modx->config['manager_time_format'],strtotime($ta['createdon'])) : '';
    $ta['publisheduntil'] = ($ta['publisheduntil'] != '0000-00-00 00:00:00') ? date($modx->config['manager_date_format'].' '.$modx->config['manager_time_format'],strtotime($ta['publisheduntil'])) : '';
    $ta['clicks'] = $modx->getCount('bdlClicks',array('listing' => $ta['id']));
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