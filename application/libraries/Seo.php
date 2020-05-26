<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Seo
{
    protected $ci;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->ci = &get_instance();
    }

    public function keywords()
    {
        // $page = $this->ci->router->method;
        // if ('index' == $this->ci->router->method) {
        //     $page = $this->ci->router->class;
        // }
        // if ($row = getRow('seo', ['page' => $page])) {
        //     $row = json_decode($row);
        // }
        // echo getSetting('site_keywords').'-'.$page;
        // echo $this->ci->router->method;
    }

    public function author()
    {
        // echo $page;
    }

    public function description()
    {
        // echo $page;
    }
}
