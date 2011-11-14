<?php
/* @var modX $modx
 * @var fiHook $hook
 * @var bdlListing $listing
 **/
$corePath = $modx->getOption('bdlistings.core_path',null,$modx->getOption('core_path').'components/bdlistings/');
$modx->getService('bdlistings','bdListings',$corePath.'model/');

$listing = $modx->newObject('bdlListing');
$listing->set('createdon',date('Y-m-d H:i:s',time()));

$d = $hook->getValues();

if ((int)$d['duration'] > 0) {
    $duration = (int)$d['duration'];
    $expires = time() + $duration;
    if ($expires > time()) $d['publisheduntil'] = $expires;
}
if (is_numeric($d['publisheduntil']))
    $d['publisheduntil'] = date('Y-m-d H:i:s',$d['publisheduntil']);
else if (!empty($d['publisheduntil']))
    $d['publisheduntil'] = date('Y-m-d H:i:s',strtotime($d['publisheduntil']));

/* If the chosen category is a subcategory, fix the references. */
if (empty($d['subcategory']) && !empty($d['category'])) {
    $cat = $modx->getObject('bdlCategory',$d['category']);
    if ($cat instanceof bdlCategory) {
        if ($cat->get('parent') > 0) {
            $d['category'] = $cat->get('parent');
            $d['subcategory'] = $cat->get('id');
        }
    } else {
        $d['category'] = 0;
    }
}

$d['active'] = false;
$d['featured'] = false;

$listing->fromArray($d);

if (!$listing->get('latitude') && !$listing->get('longitude')) {
    $listing->getLatLong();
}

$result = $listing->save();
if ($result !== true) {
    $hook->addError($modx->lexicon('bdlistings.error.save'));
    return false;
}

/* Handle file uploads */
if (is_array($d['image'])) {
    $images = array();
    $nr = 0;
    while (count($d['image']['name']) > $nr) {
        $images[] = array(
            'name' => $d['image']['name'][$nr],
            'type' => $d['image']['type'][$nr],
            'tmp_name' => $d['image']['tmp_name'][$nr],
            'size' => $d['image']['size'][$nr],
            'error' => $d['image']['error'][$nr],
        );
        $nr++;
    }

    $order = 1;
    /* @var bdlImage $img */
    foreach ($images as $i) {
        if (!empty($i['name'])) {
            $img = $modx->newObject('bdlImage',array('listing' => $listing->get('id')));
            $response = $img->handleUpload($i,$listing->get('id'));
            if (is_string($response)) {
                $img->set('image',$response);
                $img->set('sortorder',$order);
                $img->save();
                $order++;
            }
            else {
                $hook->addError('message',$modx->lexicon('bdlistings.error.fileupload',array('file' => $i['name'])).' '.$response['error']);
                return false;
            }
        }
    }
}

return true;

?>
