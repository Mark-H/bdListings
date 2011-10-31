<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$defaults = include $corePath.'elements/snippets/bdListings.properties.php';

$p = array_merge($defaults,$scriptProperties);
if ($p['acceptUrlParams']) {
    $p['acceptedUrlParams'] = (is_array($p['acceptedUrlParams'])) ? $p['acceptedUrlParams'] : explode(',',$p['acceptedUrlParams']);
    foreach ($p['acceptedUrlParams'] as $param) {
        if (!empty($_REQUEST[$param])) $p[$param] = $_REQUEST[$param];
    }
}

$c = $modx->newQuery('bdlListing');
$c->leftJoin('bdlCategory','Category');
$c->leftJoin('bdlCategory','SubCategory');
$c->leftJoin('bdlTarget','Target');
$c->leftJoin('bdlPriceGroup','PriceGroup');
$c->select(
    array(
        'bdlListing.*',
        'category_id' => '`Category`.`id`',
        'category_name' => '`Category`.`name`',
        'category_description' => '`Category`.`description`',
        'subcategory_id' => '`SubCategory`.`id`',
        'subcategory_name' => '`SubCategory`.`name`',
        'subcategory_description' => '`SubCategory`.`description`',
        'target_id' => '`Target`.`id`',
        'target_name' => '`Target`.`name`',
        'pricegroup_id' => '`PriceGroup`.`id`',
        'pricegroup_display' => '`PriceGroup`.`display`',
    )
);

$c->where(
    array(
        'publisheduntil:>' => date('Y-m-d H:i:s',time()),
        'OR:publisheduntil:=' => '0000-00-00 00:00:00',
    )
);

if (intval($p['activeOnly']) > 0) $c->where(array('active' => true));
if (intval($p['featuredOnly']) > 0) $c->where(array('featured' => true));
if (!empty($p['where'])) $c->where($p['where']);

if (!empty($p['query'])) {
    $pq = $p['query'];
    $c->where(
        array(
            'title:LIKE' => "%$pq%",
            'OR:description:LIKE' => "%$pq%",
        )
    );
}
if (!empty($p['keyword'])) $c->where(array('keyword:LIKE' => '%'.$p['keyword'].'%'));

if ($p['target'] > 0) $c->where(array('target' => $p['target']));
if ($p['pricegroup'] > 0) $c->where(array('pricegroup' => $p['pricegroup']));
if (!empty($p['city'])) $c->where(array('city:LIKE' => '%'.$p['city'].'%'));
if ($p['category'] > 0) $c->where(array('category' => $p['category']));
if ($p['subcategory'] > 0) $c->where(array('subcategory' => $p['subcategory']));

$c->limit($p['limit'],$p['start']);

$sort = $modx->fromJSON($p['sort']);
if (is_array($sort)) {
    foreach ($sort as $by => $dir) {
        $c->sortby($by,$dir);
    }
} else {
    $c->sortby($p['sortby'],$p['sortdir']);
}

$staticmap = 'http://maps.googleapis.com/maps/api/staticmap?sensor=false';

$results = array();
$collection = $modx->getCollection('bdlListing',$c);
/* @var bdlListing $listing
 * @var bdlListing $sub
 **/
foreach ($collection as $listing) {
    $ta = $listing->toArray('',false,true);
    $ta['clicks'] = $modx->getCount('bdlClicks',array('listing' => $ta['id']));

    if ($ta['latitude'] && $ta['longitude']) {
        $stm = '';
        $stm .= '&center='.$ta['latitude'].','.$ta['longitude'];
        $stm .= '&zoom='.$p['staticMapZoom'];
        $stm .= '&size='.$p['staticMapWidth'].'x'.$p['staticMapHeight'];

        $marker = '';
        if (!empty($p['staticMapMarkerIcon'])) {
            $marker .= 'icon:'.$p['staticMapMarkerIcon'].'|shadow:'.$p['staticMapMarkerIconShadow'].'|';
        } else {
            $marker .= 'color:'.$p['staticMapMarkerColor'].'|size:'.$p['staticMapMarkerSize'].'|label:'.$p['staticMapMarkerLabel'].'|';
        }
        $marker .= $ta['latitude'].','.$ta['longitude'];
        $stm .= '&markers='.urlencode($marker);
        $ta['googlemap_static'] = $staticmap.$stm;
        $ta['googlemap_url'] = 'http://maps.google.com/maps?q='.$ta['latitude'].','.$ta['longitude'];
    } else {
        /* By setting them as empty, the placeholders will still be set so you can use output filters */
        $ta['googlemap_static'] = '';
        $ta['googlemap_url'] = '';
    }

    /* Create redirect URL */
    $ta['redirect_url'] = $modx->makeUrl($p['redirectResource'],'',array('lid' => $ta['id']));

    $results[] = $modx->bdlistings->getChunk($p['tplRow'],$ta);
}

$results = implode($p['categorySeparator'],$results);
$results = $modx->bdlistings->getChunk($p['tplOuter'],array('wrapper' => $results));


return $results;