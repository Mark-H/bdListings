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
$xpdo_meta_map['bdlListing']= array (
  'package' => 'bdlistings',
  'table' => 'bdl_listing',
  'fields' => 
  array (
    'title' => NULL,
    'description' => NULL,
    'keywords' => NULL,
    'price' => NULL,
    'pricegroup' => NULL,
    'category' => NULL,
    'subcategory' => NULL,
    'target' => NULL,
    'views' => 0,
    'createdon' => 'CURRENT_TIMESTAMP',
    'publisheduntil' => NULL,
    'active' => 1,
    'featured' => 0,
    'extended' => 0,
    'companyname' => NULL,
    'contactinfo' => NULL,
    'address' => NULL,
    'phone' => NULL,
    'email' => NULL,
    'neighborhood' => NULL,
    'zip' => NULL,
    'city' => NULL,
    'country' => NULL,
    'website' => NULL,
    'latitude' => NULL,
    'longitude' => NULL,
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'keywords' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => true,
    ),
    'price' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '15,2',
      'phptype' => 'float',
      'null' => true,
    ),
    'pricegroup' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
    ),
    'category' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'fk',
    ),
    'subcategory' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'index' => 'fk',
    ),
    'target' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'fk',
    ),
    'views' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'createdon' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
    ),
    'publisheduntil' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => true,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'default' => 1,
      'null' => true,
    ),
    'featured' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'default' => 0,
      'null' => true,
    ),
    'extended' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'default' => 0,
      'null' => true,
    ),
    'companyname' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => false,
    ),
    'contactinfo' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => true,
    ),
    'address' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => true,
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
    ),
    'neighborhood' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => true,
    ),
    'zip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '32',
      'phptype' => 'string',
      'null' => true,
    ),
    'city' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
    ),
    'country' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
    ),
    'website' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '1024',
      'phptype' => 'string',
      'null' => true,
    ),
    'latitude' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
    'longitude' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '128',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'aggregates' => 
  array (
    'Category' => 
    array (
      'class' => 'bdlCategory',
      'local' => 'category',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'SubCategory' => 
    array (
      'class' => 'bdlCategory',
      'local' => 'subcategory',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Target' => 
    array (
      'class' => 'bdlTarget',
      'local' => 'target',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'PriceGroup' => 
    array (
      'class' => 'bdlPriceGroup',
      'local' => 'pricegroup',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'Images' => 
    array (
      'class' => 'bdlImage',
      'local' => 'id',
      'foreign' => 'listing',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
