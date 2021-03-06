<?php
namespace matt127127\MigrationPath;


use matt127127\MigrationPath\Exceptions\InvalidPathException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class MultipleMigrationPaths
{

    /**
     * @var array
     */
    protected $paths = [];

    public function __construct(array $config = [])
    {
        $this->paths = $config['paths'];
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function getRegisteredPaths()
    {
        $paths = [];

        foreach ( $this->paths as $path ) {
            throw_unless(file_exists($path), InvalidPathException::class, $path);
            $paths = array_merge($paths, $this->getPaths($path));
        }

        return $paths;
    }

    /**
     * @return array
     */
    private function getPaths($path)
    {
        $paths = [];

        $iterators = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterators as $iterator) {
            if ($iterator->isDir()) {
                $paths[] = $iterator->getRealPath();
            }
        }

        return $paths;
    }
}
