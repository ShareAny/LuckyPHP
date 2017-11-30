<?php

/**
 * CodeMommy WebPHP
 * @author Candison November <www.kandisheng.com>
 */

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use CodeMommy\WebPHP\Application;

/**
 * Class ApplicationTest
 * @package Test
 */
class ApplicationTest extends TestCase
{
    /**
     * @var string
     */
    private $casePath = '';

    /**
     * @var string
     */
    private $caseConfigPath = '';

    /**
     * ApplicationTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->casePath = './test/case';
        $this->caseConfigPath = $this->casePath . '/config/';
    }

    /**
     * Test Construct
     */
    public function testConstruct()
    {
        new Application();
        $this->assertEquals(true, true);
    }

    /**
     * Test Start
     */
    public function testStart()
    {
        copy($this->caseConfigPath . 'route_symfony.php', $this->caseConfigPath . 'route.php');
        $_SERVER['REQUEST_URI'] = '/test/symfony';
        Application::start($this->casePath);
        $this->expectOutputString('symfony');
    }
}
