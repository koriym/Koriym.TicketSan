<?php
namespace Deployer;

require __DIR__ . '/recipe/bearsunday.php';

// Hosts
inventory('servers.yml');

// Migration
after('deploy:symlink', 'deploy:setup');

// Restart web server
//after('deploy:symlink', 'apache2:restart');
