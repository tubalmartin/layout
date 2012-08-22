# Layout
## An advanced layout library for CodeIgniter.

Many CodeIgniter learners still find it difficult to apply templates to their projects. The layout library makes it simple for both new and experienced CodeIgniter coders to add nested templates to their application.

Templates are defined in a simple array format, and can be as simple or as complex as you like, built to suit your ever need.

**Table of Contents** 

1.  [Installation](#installation)
2.  [Render a View](#render)
3.  [Using Templates](#templates)
4.  [Binding Data to Views](#bindings)

<a name="installation"></a>
### Installation

Install it as a `spark`.

<a name="render"></a>
### Render a View

To display a view, simply use the `show()` method. It will render the supplied view using the default *main* as defined in the layout config file at `config/layout.php`.

To return a view as a string use the `get()` method.

```php
<?php

$this->layout->show('my_view');

$string_view = $this->layout->get('my_view');
```

<a name="templates"></a>
### Using Templates

Pre-defined templates allow you to nest your view within a combination of other views, allowing you to create 'site-wrappers' and other forms of layout combinations.

Layouts are defined in the config file at `config/layout.php` in the `$config['layout']['templates']` array.

```php
<?php

$config['layout']['templates'] = array(

  // default template
  'main'  =>  array(
    '-YIELD-',
  ),


  // template_1
  'template_1'  =>  array(
    'my_header',
    '-YIELD-',
    'my_footer'
  )  

);
```    

In the above example, `'main'` is a template that is provided by default with the layout library, it will simply show the view passed to the layout library using the `show()` method.

The template `'template_1'` will first render the view file `'my_header'` then it will *yield* to the view specified by `show()` and finally, it will render the view file `'my_footer'`.

To specify a template, simply use the `template()` method, which is chainable :

```php
<?php

$this->layout->template('template_1')->show('my_view');

// or..

$this->layout->template('template_1');
$this->layout->show('my_view');
```    

<a name="bindings"></a>
### Binding Data to Views

You may pass an array as a second paramater to the `show()` method, to provide an array of view variables that are accessible in the same way as with `$this->load->view('view', $vars);`. *Infact, the layout library passed the data to the CodeIgniter this way, it simply serves as a wrapper!*

In the controller:
```php
<?php

$this->layout->show('my_view', array('dog' = 'Rover'));
```
In the view:
```html
<p><?php echo $dog; // Rover ?></p> 
```    

You can alternatively use the `bind()` method to provide variables to the view, or a combination of both methods. The `bind()` accepts two parameters, a string index, and its value. This method is also chainable.

```php
<?php

$this->layout->bind('dog', 'Rover')->show('my_view');
```
