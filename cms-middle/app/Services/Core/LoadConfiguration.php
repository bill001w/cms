<?php

namespace App\Services\Core;

use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadConfiguration
{
    private $config_path;

    public function __construct($config_path)
    {
        $this->config_path = $config_path;
        $this->loadConfigurationFiles(app(RepositoryContract::class));
    }

    protected function loadConfigurationFiles(RepositoryContract $repository)
    {
        foreach ($this->getConfigurationFiles() as $key => $path) {
            $repository->set($key, require $path);
        }
    }

    protected function getConfigurationFiles()
    {
        $files = [];

        foreach (Finder::create()->files()->name('*.php')->in($this->config_path) as $file) {
            $nesting = $this->getConfigurationNesting($file, $this->config_path);

            $files[$nesting . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    protected function getConfigurationNesting(SplFileInfo $file, $configPath)
    {
        $directory = dirname($file->getRealPath());

        if ($tree = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree) . '.';
        }

        return $tree;
    }
}
