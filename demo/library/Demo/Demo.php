<?php

/**
 * CodeMommy WebPHP
 * @author Candison November <www.kandisheng.com>
 */

namespace Library;

use CodeMommy\CookiePHP\Cookie;
use CodeMommy\CachePHP\Cache;
use CodeMommy\ConfigPHP\Config;
use CodeMommy\IsPHP\Is;
use CodeMommy\RequestPHP\Request;
use CodeMommy\ResponsePHP\Response;
use CodeMommy\ClientPHP\Client;
use CodeMommy\ServerPHP\Server;
use CodeMommy\SessionPHP\Session;
use CodeMommy\ConvertPHP\Convert;
use CodeMommy\ImagePHP\Image;
use CodeMommy\WebPHP\Application;
use CodeMommy\WebPHP\Controller;
use CodeMommy\WebPHP\Debug;
use CodeMommy\WebPHP\Database;
use CodeMommy\WebPHP\DateTime;
use CodeMommy\WebPHP\Log;
use CodeMommy\WebPHP\Mail;
use CodeMommy\WebPHP\View;
use CodeMommy\WebPHP\Environment;
use Model\Demo as ModelDemo;
use Library\HelloWorld;

/**
 * Class Demo
 * @package Library
 */
class Demo
{
    /**
     * Render Page
     */
    public static function renderPage()
    {
        $data = array();
        $data['title'] = 'Hello World';
        return View::render('demo', $data);
    }

    /**
     * Load Library
     */
    public static function loadLibrary()
    {
        HelloWorld::show();
    }

    /**
     * Request Information
     */
    public static function requestInformation()
    {
        Debug::show(sprintf('Root: %s', Request::root()));
        Debug::show(sprintf('URL: %s', Request::url()));
        Debug::show(sprintf('Domain: %s', Request::domain()));
        Debug::show(sprintf('Scheme: %s', Request::scheme()));
        Debug::show(sprintf('Path: %s', Request::path()));
        Debug::show(sprintf('Query: %s', Request::query()));
    }

    /**
     * Server Information
     */
    public static function serverInformation()
    {
        Server::information();
    }

    /**
     * Time
     */
    public static function time()
    {
        $result = DateTime::now()->toDateTimeString();
        Debug::show($result);
    }

    public static function database()
    {
        $database = new Database();
        $result = $database::table('book')->get();
        Debug::show($result);
    }

    public static function databasePaginate()
    {
        $database = new Database();
        $result = $database::table('book')->paginate(2);
        echo $result->render();
    }

    public static function model()
    {
        $result = ModelDemo::all();
        Debug::show($result);
    }

    public static function redirect()
    {
        return Response::redirect('http://www.microsoft.com');
    }

    public static function cookie()
    {
        Cookie::set('hello', 'world');
        echo Cookie::get('hello');
    }

    public static function session()
    {
        echo Session::set('hello', 'world');
        echo Session::get('hello');
        echo Session::isExist('hello');
        echo Session::clear();
    }

    public static function showJSON()
    {
        $data = array();
        $data['hello'] = 'Hello';
        $data['world'] = 'World';
        return Response::json($data);
    }

    public static function input()
    {
        echo Request::inputGet('hello', 'default');;
    }

    public static function debug()
    {
        Debug::show('hello');
        $data = array();
        $data['hello'] = 'Hello';
        $data['world'] = 'World';
        Debug::show($data);
    }

    public static function config()
    {
        echo Config::get('database.mysql.host');
    }

    public static function client()
    {
        Debug::show(Client::system());
        Debug::show(Client::browser());
        Debug::show(Client::equipment());
        Debug::show(Client::ip());
        Debug::show(Client::language());
        Debug::show(Client::isWeChat());
    }

    public static function is()
    {
        Debug::show(Is::email('demo@demo.com'));
        Debug::show(Is::email('demo'));
        Debug::show(Is::chinaCellPhoneNumber('15555555555'));
        Debug::show(Is::chinaCellPhoneNumber('1555555555'));
    }

    public static function convert()
    {
        $data = array();
        $data['hello'] = 'Hello';
        $data['world'] = 'World';
        echo Convert::arrayToJSON($data);
    }

    /**
     * Log
     */
    public static function log()
    {
        $log = new Log('Demo', Application::getPath('_runtime/log/log.log'));
        $log->debug('Debug', array('Debug'));
        $log->info('Info', array('Info'));
        $log->notice('Notice', array('Notice'));
        $log->warning('Warning', array('Warning'));
        $log->error('Error', array('Error'));
        $log->critical('Critical', array('Critical'));
        $log->alert('Alert', array('Alert'));
    }

    public static function mail()
    {
        $mail = new Mail('', 25, '', '');
        $result = $mail->send('', '', '', '', '', '');
        Debug::show($result);
    }

    public static function cache()
    {
        Cache::writeValue('cache', 'test', 10);
        echo Cache::readValue('cache');
    }

    public static function upload()
    {
        Request::inputFile('file', 'static/upload/');
    }
}