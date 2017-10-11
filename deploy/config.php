<?php

namespace Deployer;

/***************
* SSH
****************/

set('ssh_type', 'native');
set('ssh_multiplexing', true);

/***************
* STAGING
****************/

set('default_stage', 'production');

/***************
* REPOSITORY
****************/

set('repository', 'git@github.com:username/repository.git');

/***************
* RELEASES
****************/

set('keep_releases', 2);

/***************
* FOLDERS
****************/

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);
