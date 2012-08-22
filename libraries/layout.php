<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      EllisLab Dev Team
 * @copyright   Copyright (c) 2006 - 2011, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Multi-Template Layout Library
 *
 * This class enables you to render advanced templates consisting of a
 * number of different CodeIgniter style view files.
 *
 * @package     Layout
 * @subpackage  Libraries
 * @version     0.9 beta
 * @category    Libraries
 * @copyright   Copyright (c) 2011 Dayle Rees.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        https://github.com/daylerees/layout
 * @author      Dayle Rees
 * @link
 */
class Layout
{
    // config loaded templates & default values
    private $templates              = array();
    private $default_values         = array();

    // values set by the chain
    private $active_template        = 'main';
    private $data                   = array();

    // reference to the codeigniter object
    private $ci;

    public function __construct()
    {
        // get the config
        $config = config_item('layout');

        // set the templates & default values from the config
        $this->templates = $config['templates'];
        $this->default_values = $config['default_values'];

        // get hold of the codeigniter object
        $this->ci =& get_instance();
    }

    // --------------------------------------------------------------------

    /**
     * Render the view.
     *
     * @access public
     * @param string The view to display.
     * @param array Data to provide to the view.
     * @param bool Boolean to return view as string or not
     * @return void|string
     */
    public function render($view, $data = null, $return = false)
    {
        // Container for the generated view as a string
        $view_string = '';

        // if we have been given data, merge it
        if($data != null && is_array($data))
        {
            $this->data = array_merge($this->data, $data);
        }

        // fill the blanks!
        $this->data = $this->_prepare($this->data);

        if(! isset($this->templates[$this->active_template]))
        {
            // if the template doesnt exist, show an error
            echo "Template '{$this->active_template}' not found.";
            return false;
        }

        // loop through each template view
        foreach($this->templates[$this->active_template] as $temp)
        {
            // yield inserts the main content
            $_view = $temp === '-YIELD-' ? $view : $temp;

            if ($return === true)
            {
                $view_string .= $this->ci->load->view($_view, $this->data, true);
            }
            else
            {
                $this->ci->load->view($_view, $this->data);
            }
        }

        // reset the chain, clankety clank
        $this->_cleanup();

        // View as string? return it
        if ($return === true)
        {
            return $view_string;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Show the view.
     *
     * @access public
     * @param string The view to display.
     * @param array Data to provide to the view.
     * @return void
     */
    public function show($view, $data = null)
    {
        $this->render($view, $data);
    }

    // --------------------------------------------------------------------

    /**
     * Get the view.
     *
     * @access public
     * @param string The view to display.
     * @param array Data to provide to the view.
     * @return string
     */
    public function get($view, $data = null)
    {
        return $this->render($view, $data, true);
    }

    // --------------------------------------------------------------------

    /**
     * Select a different template.
     *
     * @access public
     * @param string The name of the template.
     * @return Layout
     */
    public function template($template)
    {
        // set the template to use, defaults to the first
        $this->active_template = $template;

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Bind a value to the view.
     *
     * @access public
     * @param string The variable name.
     * @param mixed The value.
     * @return Layout
     */
    public function bind($key, $value)
    {
        // add the value to our data array
        $this->data[$key] = $value;

        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Bind a value to the view.
     *
     * @access private
     * @param array The view data array.
     * @return array The Modified view data array.
     */
    private function _prepare($data)
    {
        // add our default values, but existing ones take priority
        $data = array_merge($this->default_values, $data);

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Reset all values after a chain trigger.
     *
     * @access private
     */
    private function _cleanup()
    {
        // reset the chain using default values
        $this->active_template = 'main';
        $this->data = array();
    }
}