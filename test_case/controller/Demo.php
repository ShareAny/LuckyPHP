<?php

/**
 * CodeMommy WebPHP
 * @author Candison November <www.kandisheng.com>
 */

namespace Controller;

use CodeMommy\RequestPHP\Request;
use CodeMommy\ViewPHP\View;
use Library\DemoList;

/**
 * Class Demo
 * @package Controller
 */
class Demo
{
    /**
     * Demo constructor.
     */
    public function __construct()
    {
    }

    /**
     * Index
     * @return mixed
     */
    public function index()
    {
        $data = array();
        // Demo List
        $demoMethods = get_class_methods('Library\DemoList');
        sort($demoMethods);
        $notShow = array();
        foreach ($demoMethods as $key => $value) {
            if (in_array($value, $notShow)) {
                unset($demoMethods[$key]);
            }
        }
        $data['demoList'] = $demoMethods;
        // Title
        $data['title'] = 'CodeMommy WebPHP Demo';
        $action = Request::inputGet('action', '');
        $data['action'] = $action;
        if (!empty($action)) {
            $data['title'] = sprintf('%s: %s', $data['title'], $action);
            DemoList::$action();
        }
        // Render
        $data['root'] = Request::root();
        return View::render(__FUNCTION__, $data);
    }
}