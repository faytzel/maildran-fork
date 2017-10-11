<?php

namespace Deployer;

// laravel tasks in vendor/deployer/deployer/recipe/laravel.php

before('deploy:prepare', 'code:lint');
before('deploy:prepare', 'code:test');
before('deploy:prepare', 'composer:check');

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'artisan:migrate');
before('deploy:symlink', 'deploy:public_disk');
before('deploy:symlink', 'upload:assets');

after('deploy:symlink', 'php-fpm:reload');
after('deploy:symlink', 'artisan:down');
after('deploy:symlink', 'artisan:route:cache');
after('deploy:symlink', 'cache:clear');
after('deploy:symlink', 'artisan:up');
//after('deploy:symlink', 'artisan:queue:restart');
