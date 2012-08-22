<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Layout: Config item wrapper.
|--------------------------------------------------------------------------
|
*/

$config['layout'] = array();

/*
|--------------------------------------------------------------------------
| Layout: Templates.
|--------------------------------------------------------------------------
|
| This array contains a list of templates that are available to the layout
| library. The primary array key must be the name used to identify the
| template, the value contains an array of CodeIgniter named views that
| will be rendered in sequence.
|
| Use '-YIELD-' to load the primary view that is passed to the layout
| library at run time.
|
| For example :
|
|   'my_template'   =>  array(
|       'header_template',
|       '-YIELD-',
|       'footer_template'
|   )
*/

$config['layout']['templates'] = array(

    // default template
    'main'  =>  array(
        '-YIELD-'
    )
);

/*
|--------------------------------------------------------------------------
| Layout: Default Values
|--------------------------------------------------------------------------
|
| These default values will be available to all views loaded using the
| layout library. You may use the bind() method to overwrite them at
| run time.
|
*/

$config['layout']['default_values'] = array(
    // format 'key' => 'value',
);