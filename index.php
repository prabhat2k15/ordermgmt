<?php

namespace app {

    use bootphp\rudrax\AppLoader;

    include_once "lib/autoload.php";

    class Index extends AppLoader
    {
        public static $DISPLAY_ERROR = TRUE;
        public static $RX_MODE_DEBUG = TRUE;

        public function __construct()
        {
            //ini_set('display_errors', 0);
            //ini_set('error_reporting', 0);
            //error_reporting(0);
            error_reporting(E_ERROR | E_PARSE);
        }

        public function __destruct()
        {
            // TODO: Implement __destruct() method.
           // echo "What CAN I DO FOR YOU";
        }
    }

    (new Index())->execute(__DIR__);
}
  