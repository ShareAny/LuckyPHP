<?php

/**
 * CodeMommy WebPHP
 * @author  Candison November <www.kandisheng.com>
 */

namespace CodeMommy\WebPHP;

use Illuminate\Database\Capsule\Manager;

class Database extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $databaseType = Config::get('database.type');
        $database = Config::get('database.' . $databaseType);
        $database['driver'] = $databaseType;
        $this->addConnection($database);
        $this->setAsGlobal();
        $this->bootEloquent();
    }
}