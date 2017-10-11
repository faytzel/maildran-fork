<?php

namespace Deployer;

/***************
* PRODUCTION
****************/

host('example.com')
    ->stage('production')
    ->roles('app')
    ->user('root')
    ->identityFile('~/.ssh/key')
    ->set('deploy_path', '/var/www/project')
    ->set('branch', 'master');
