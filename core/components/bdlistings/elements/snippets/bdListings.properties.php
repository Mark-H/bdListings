<?php

return array(
    'limit' => 0,
    'start' => 0,
    'sort' => '{"city": "ASC", "neighborhood": "ASC", "companyname": "ASC"}',
    'sortby' => 'title',
    'sortdir' => 'ASC',

    'activeOnly' => true,
    'featuredOnly' => false,
    'where' => '',
    'acceptUrlParams' => true,
    'acceptedUrlParams' => array(
        'query','keyword','target','pricegroup','city','category','subcategory','sort','listings',
    ),
    'query' => '',
    'keyword' => '',
    'target' => 0,
    'pricegroup' => 0,
    'city' => '',
    'category' => 0,
    'subcategory' => 0,

    'listings' => '',

    'redirectResource' => 39,

    'staticMapWidth' => 150,
    'staticMapHeight' => 150,
    'staticMapZoom' => 12,
    'staticMapType' => 'hybrid',
    'staticMapMarkerColor' => 'red',
    'staticMapMarkerLabel' => 'A', // Text on the marker (only 1 upper char / number)
    'staticMapMarkerSize' => 'medium', //tiny|mid|small|medium
    'staticMapMarkerIcon' => '', // Example: http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe%7C996600
    'staticMapMarkerIconShadow' => 'true',

    'rowSeparator' => "\n",
    'imageSeparator' => " \n",
    'tplOuter' => 'bdListings.outer',
    'tplRow' => 'bdListings.row',
    'tplImage' => 'bdListings.image',

    'emptyValue' => '[[%bdlistings.noresults? &namespace=`bdlistings`]]'
);

?>
