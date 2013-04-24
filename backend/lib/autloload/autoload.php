<?php

include_once(dirname(__FILE__).'/autoloadManager.php');



class Autoload extends AutoloadManager
{
    public function loadClass($className)
    {
        $className = strtolower($className);
        $className = trim($className, '\\');

        return parent::loadClass($className);
    }

}
