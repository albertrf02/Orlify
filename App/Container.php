<?php


namespace App;

use Emeset\Container as EmesetContainer;

class Container extends EmesetContainer
{

    public function __construct($config)
    {
        parent::__construct($config);

        $dbType = $this->get("config")["db_type"];
        if ($dbType == "PDO") {

            $this["users"] = function ($c) {
                return new \App\Models\Users($c["db"]->getConnection());
            };
            $this["orles"] = function ($c) {
                return new \App\Models\Orles($c["db"]->getConnection());
            };
            $this["classes"] = function ($c) {
                return new \App\Models\Classes($c["db"]->getConnection());
            };

            $this["db"] = function ($c) {
                return new \App\Models\Db(
                    $c["config"]["db"]["user"],
                    $c["config"]["db"]["pass"],
                    $c["config"]["db"]["db"],
                    $c["config"]["db"]["host"]
                );
            };
        }
    }
}