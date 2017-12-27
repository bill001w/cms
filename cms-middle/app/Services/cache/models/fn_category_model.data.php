<?php

return array (
  'types' => 
  array (
    'catid' => 'smallint unsigned',
    'modelid' => 'smallint',
    'parentid' => 'smallint unsigned',
    'arrparentid' => 'varchar',
    'child' => 'tinyint unsigned',
    'arrchildid' => 'varchar',
    'catname' => 'varchar',
    'catdir' => 'varchar',
    'image' => 'varchar',
    'items' => 'mediumint unsigned',
    'pagesize' => 'smallint',
    'listorder' => 'smallint unsigned',
    'meta_title' => 'varchar',
    'meta_keywords' => 'text',
    'meta_description' => 'text',
    'categorytpl' => 'varchar',
    'listtpl' => 'varchar',
    'showtpl' => 'varchar',
    'ismenu' => 'tinyint unsigned',
    'setting' => 'text',
  ),
  'fields' => 
  array (
    0 => 'catid',
    1 => 'modelid',
    2 => 'parentid',
    3 => 'arrparentid',
    4 => 'child',
    5 => 'arrchildid',
    6 => 'catname',
    7 => 'catdir',
    8 => 'image',
    9 => 'items',
    10 => 'pagesize',
    11 => 'listorder',
    12 => 'meta_title',
    13 => 'meta_keywords',
    14 => 'meta_description',
    15 => 'categorytpl',
    16 => 'listtpl',
    17 => 'showtpl',
    18 => 'ismenu',
    19 => 'setting',
  ),
  'primary_key' => 'catid',
);