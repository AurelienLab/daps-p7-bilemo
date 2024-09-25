<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'git@github.com:AurelienLab/daps-p7-bilemo.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('prod')
    ->set('hostname', 'vmedias-prod') // requires config in ~/.ssh/config
    ->set('deploy_path', '/srv/www/daps/p7')
    ->set('branch', 'main')
;

// Hooks

after('deploy:failed', 'deploy:unlock');
