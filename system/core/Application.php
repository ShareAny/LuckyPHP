<?php

/**
 * CodeMommy WebPHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\WebPHP;

use Whoops\Run;
use Whoops\Util\Misc;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use CodeMommy\AutoloadPHP\Autoload;
use CodeMommy\CachePHP\Cache;
use CodeMommy\ConfigPHP\Config;
use CodeMommy\WebPHP\Route;
use CodeMommy\WebPHP\Debug;

/**
 * Class Application
 * @package CodeMommy\WebPHP
 */
class Application
{
    /**
     * @param $path
     *
     * @return bool
     */
    public static function start($path)
    {
        // Define Path
        if (substr($path, -1) == '/' || substr($path, -1) == '\\') {
            $path = substr($path, 0, -1);
        }
        define('APPLICATION_ROOT', $path);
        // Config
        Config::setRoot(APPLICATION_ROOT . '/config');
        /* Debug Old
        error_reporting(0);
        ini_set('display_errors', 'Off');
        $isDebug = Config::get('application.debug', false);
        if ($isDebug) {
            register_shutdown_function(function () {
                $error = error_get_last();
                if (is_array($error)) {
                    Debug::show($error);
                }
            });
        }
        */
        // Debug
        $isDebug = Config::get('application.debug', false);
        if ($isDebug) {
            $whoops = new Run();
            if (Misc::isAjaxRequest()) {
                $whoops->pushHandler(new JsonResponseHandler);
            } else {
                $whoops->pushHandler(new PrettyPageHandler());
            }
            $whoops->register();
        }
        // Load Library
        $library = Config::get('library', array());
        if (is_array($library)) {
            foreach ($library as $key => $value) {
                $file = APPLICATION_ROOT . '/library/' . $value;
                Autoload::file($file, $key);
            }
        }
        // Other
        Autoload::load(APPLICATION_ROOT . '/controller', 'Controller');
        Autoload::load(APPLICATION_ROOT . '/model', 'Model');
        Autoload::load(APPLICATION_ROOT, '');
        Cache::setConfig(Config::get('cache'));
        Route::start();
        return true;
    }
}