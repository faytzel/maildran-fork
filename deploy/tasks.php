<?php

namespace Deployer;

desc('FPM reload');
task('php-fpm:reload', function () {
    $output = run('sudo /etc/init.d/php7.1-fpm reload');
    writeln('<info>' . $output . '</info>');
});

desc('Test PHP code');
task('code:test', function () {
    $output = runLocally('php vendor/bin/phpunit');
    writeln('<info>' . $output . '</info>');
});

desc('Lint PHP code');
task('code:lint', function () {
    $output = runLocally('php codesniffer');
    writeln('<info>' . $output . '</info>');
});

desc('Upload local assets');
task('upload:assets', function () {
    writeln('<info>Generating assets...</info>');
    $output = runLocally('npm run production');
    writeln('<info>' . $output . '</info>');

    writeln('<info>Upload JS</info>');
    upload('public/js/', '{{release_path}}/public/js');

    writeln('<info>Upload CSS</info>');
    upload('public/css/', '{{release_path}}/public/css');

    writeln('<info>Upload Fonts</info>');
    upload('public/fonts/', '{{release_path}}/public/fonts');

    writeln('<info>Upload Manifest</info>');
    upload('public/mix-manifest.json', '{{release_path}}/public/mix-manifest.json');
});

desc('Custom app cache clear');
task('cache:clear', function () {
    $output = run('{{bin/php}} {{deploy_path}}/current/artisan app:cache-temporal:clear');
    writeln('<info>' . $output . '</info>');
});

desc('Composer security checker');
task('composer:check', function () {
    // hace peticion a security.sensiolabs.org
    $checker = new \SensioLabs\Security\SecurityChecker();

    $filename = __DIR__ . '/../composer.lock';
    if (file_exists($filename)) {
        $output = $checker->check($filename);
        writeln('<info>' . json_encode($output) . '</info>');
    } else {
        writeln('<info>composer.lock not found</info>');
    }
});
