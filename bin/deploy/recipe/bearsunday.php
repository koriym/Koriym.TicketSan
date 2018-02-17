<?php

require 'recipe/common.php';

use function Deployer\run;
use function Deployer\runLocally;
use function Deployer\set;
use function Deployer\task;
use function Deployer\upload;

// Configuration
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
set('shared_files', []);

// BEAR.Sunday shared dirs
set('shared_dirs', ['var/log']);
// BEAR.Sunday writable dirs
set('writable_dirs', ['var/tmp', 'var/log']);

task('deploy:env', function () {
    upload('{{dotenv}}', '{{release_path}}/.env');
});

// Migration
task('deploy:setup', function () {
    run('
        cd {{release_path}};
        composer setup;
    ');
});

task('deploy:npm', function () {
    runLocally('
        cd ..;
        npm install;
        npm run build;        
    ', 600);
    $dir = dirname(dirname(dirname(__DIR__)));
    upload($dir . '/var/www/dist', '{{release_path}}/var/www/dist');
});

task('deploy:compile', function () {
    run('
        cd {{release_path}};
        vendor/bin/bear.compile \'{{appname}}\' {{context}} {{release_path}}
    ');
});

task('apache2:restart', function () {
    // The user must have rights for restart service
    run('sudo service apache2 restart');
});

// Tasks
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:env',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:compile',
    'deploy:unlock',
    'cleanup',
    'success'
])->desc('Deploy your project');
