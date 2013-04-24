<?php



class autoloadAll extends Autoload
{
    /**
     * Parse folder and update $_classes array
     *
     * @param string $folder Folder to process
     * @return array Array containing all the classes found
     */
    private function parseFolder($folder)
    {
        $classes = array();
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));

        var_dump($files);

        foreach ($files as $file)
        {
            if ($file->isFile() && preg_match($this->_filesRegex, $file->getFilename()))
            {
                foreach ($this->_excludedFolders as $folder)
                {
                    $len = strlen($folder);
                    if (0 === strncmp($folder, $file->getPathname(), $len))
                    {
                        continue 2;
                    }
                }

                if ($classNames = $this->getClassesFromFile($file->getPathname()))
                {
                    foreach ($classNames as $className)
                    {
                        // Adding class to map
                        $classes[$className] = $file->getPathname();
                    }
                }
                else{
                    $classes[] = $file->getPathname();
                }
            }
        }
        return $classes;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));

        $this->refresh();
        $this->generate();        
    }
}
