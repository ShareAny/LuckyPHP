<?php

/**
 * CodeMommy WebPHP
 * @author Candison November <www.kandisheng.com>
 */

namespace CodeMommy\Script;

/**
 * Class Install
 */
class Install
{
    /**
     * Install constructor.
     */
    public function __construct()
    {
    }

    /**
     * Delete Directory
     * @param string $path
     */
    private static function deleteDirectory($path = '')
    {
        $directory = dir($path);
        while (($item = $directory->read()) !== false) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $file = $directory->path . '/' . $item;
            if (is_dir($file)) {
                self::deleteDirectory($file);
                continue;
            }
            unlink($file);
        }
        $directory->close();
        rmdir($path);
    }

    /**
     * Remove
     * @param string $file
     */
    private static function remove($file = '')
    {
        if (is_dir($file)) {
            self::deleteDirectory($file);
        }
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Start
     * @param $versionComposer
     */
    public static function start($versionComposer = '*')
    {
        // Remove
        $removeList = array(
            'manual',
            'script',
            'system',
            'test',
            'test_case',
            '.coveralls.yml',
            '.develop.json',
            '.travis.yml',
            'autoload.php',
            'phpunit.xml'
        );
        foreach ($removeList as $file) {
            self::remove($file);
        }
        // Copy
        copy('application/config/environment.example.yaml', 'application/config/environment.yaml');
        // Composer
//        $versionComposer = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '*';
        $data = array(
            'require' => array(
                'codemommy/webphp' => $versionComposer
            )
        );
        $composerJSON = json_encode($data, JSON_PRETTY_PRINT);
        $composerJSON = str_replace('\\', '', $composerJSON);
        $composerFile = 'composer.json';
        file_put_contents($composerFile, $composerJSON);
        system('composer update');
    }
}

//Install::start();
