<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('resources')
    ->exclude('tests')
    ->in('src/');

return new Sami($iterator, array(
    'theme'                => 'default',
    'title'                => 'Ghostly ORM API',
    'build_dir'            => __DIR__.'/docs/api',
    'cache_dir'            => __DIR__.'/docs/cache',
    'default_opened_level' => 2,
));