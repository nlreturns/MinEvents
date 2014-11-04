<?php
namespace minevents\app;

use minevents\app\core\SplClassLoader;

include 'config/constants.php';
include 'config/db_constants.php';
include 'core/SplClassLoader.php';

class Bootstrap
{

    const INIT_PREFIX = 'init';

    /**
     * De constructor zorgt ervoor dat alle functies die beginnen met 'init'
     * worden opgeroepen.
     * @param null $configuration
     */
    public function __construct($configuration = null)
    {
        /* Iterate trough all methods in Bootstrap class. */
        foreach (\get_class_methods($this) as $method) {
            /* Check if method starts with the 4 letters defined in
             * Bootstrap::INIT_PREFIX. If so; provoke this method passing
             * __construct parameters*/
            if (\substr($method, 0, 4) === self::INIT_PREFIX) {
                call_user_func_array(array($this, $method), func_get_args());
            }
        }
    }

    /**
     * Deze functie initieert de Autoloader.
     */
    private function initAutoloader()
    {
        $autoloader = new SplClassLoader('minevents\app', '../../');
        $autoloader->register();
    }
} 