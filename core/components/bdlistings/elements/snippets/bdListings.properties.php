<?php

return array(
    'limit' => 0,
    'start' => 0,
    'sortby' => 'title',
    'sortdir' => 'ASC',

    'activeOnly' => true,
    'featuredOnly' => false,
    'where' => '',
    'acceptUrlParams' => true,
    'acceptedUrlParams' => array(
        'query','keyword','target','pricegroup','city','category','subcategory','sortby','sortdir'
    ),
    'query' => '',
    'keyword' => '',
    'target' => 0,
    'pricegroup' => 0,
    'city' => '',
    'category' => 0,
    'subcategory' => 0,

    'staticMapWidth' => 150,
    'staticMapHeight' => 150,
    'staticMapZoom' => 12,
    'staticMapType' => 'hybrid',
    'staticMapMarkerColor' => 'red',
    'staticMapMarkerLabel' => 'A',
    'staticMapMarkerSize' => 'medium', //tiny|mid|small|medium
    'staticMapMarkerIcon' => 'http://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe%7C996600',
    'staticMapMarkerIconShadow' => 'true',

    'rowSeparator' => "\n",

    'tplOuter' => 'bdListings.outer',
    'tplRow' => 'bdListings.row',
);

?>
