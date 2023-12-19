<?php

return [
    /* configuració de connexió a la base dades */
    /* Path on guardarem el fitxer sqlite */
    "db_type" => Emeset\Env::get("db_type", "PDO"),
    "sqlite" => [
        "path" => Emeset\Env::get("sqlite_path", "../"),
        "name" => Emeset\Env::get("sqlite_name", "db.sqlite")
    ],
    "db" => [
        "user" => Emeset\Env::get("user", "root"),
        "pass" => Emeset\Env::get("pass", ""),
        "db" => Emeset\Env::get("db", "orlify"),
        "host" => Emeset\Env::get("host", "localhost")
    ],
    "url" => Emeset\Env::get("url", "localhost")

];
