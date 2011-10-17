<?php
/**
 * bdListings
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of bdListings, a real estate property listings component
 * for MODX Revolution.
 *
 * bdListings is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * bdListings is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * bdListings; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
$xpdo_meta_map['bdlClicks']= array (
  'package' => 'bdlistings',
  'table' => 'bdl_clicks',
  'fields' => 
  array (
    'listing' => NULL,
    'clicktime' => 'CURRENT_TIMESTAMP',
    'ipaddress' => '127.0.0.1',
    'referrer' => '- no referer available -',
  ),
  'fieldMeta' => 
  array (
    'listing' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
    'clicktime' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
    ),
    'ipaddress' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => false,
      'default' => '127.0.0.1',
    ),
    'referrer' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '512',
      'phptype' => 'string',
      'null' => false,
      'default' => '- no referer available -',
    ),
  ),
  'aggregates' => 
  array (
    'Listings' => 
    array (
      'class' => 'bdlListing',
      'local' => 'listing',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
  ),
);
