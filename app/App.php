<?php

namespace App;

use App\Core\DB;
use App\Core\Router;

class App
{
    /**
     * The database.
     */
    public DB $db;

    /**
     * The router.
     */
    public Router $router;

    /**
     * Construct the app.
     */
    public function __construct()
    {
        $this->db = new DB();
        $this->router = new Router();
    }

    /**
     * Run the app.
     *
     * @return void
     */
    public function run(): void
    {
        $this->router->dispatch();
    }
}
