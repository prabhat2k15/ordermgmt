<?php

namespace app {

    include_once "../lib/autoload.php";

    use bootphp\cache\HardCache;
    use bootphp\fn;
    use bootphp\project;

    class NoIndex extends \bootphp\loader\Loader
    {
        public static $DISPLAY_ERROR = TRUE;
        public static $RX_MODE_DEBUG = TRUE;

        public function __construct()
        {
            //ini_set('display_errors', 0);
            //ini_set('error_reporting', 0);
            //error_reporting(0);
            error_reporting(E_ERROR | E_PARSE);
            error_reporting(E_ALL);
        }

        public function invoke($option)
        {
           fn::println("===");

        }

        public function __destruct()
        {
            // TODO: Implement __destruct() method.
            // echo "What CAN I DO FOR YOU";
        }
    }

    (new NoIndex())->execute(__DIR__);
}