<?php
class autoloader {
    public static $loader;
    
    public static function init()
    {
        if (self::$loader == NULL)
            self::$loader = new self();
    
        return self::$loader;
    }
    
    public function __construct() {
        spl_autoload_register(array($this,'load'));
    }
    
    public function load($className) { 
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
    
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
    
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    
        if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . $fileName)) {
            include $fileName;
        }
    }
}