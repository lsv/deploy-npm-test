<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

task('npm-install', function() {
    run("cd {{release_path}} && npm install");
});

task('bower-install', function() {
    run("cd {{release_path}} && node_modules/.bin/bower --allow-root install");
});

after('deploy:vendors', 'npm-install');
after('npm-install', 'bower-install');

set('repository', 'git@github.com:lsv/deploy-npm-test.git');

localServer('local')
    ->stage('local')
    ->env('deploy_path', '/tmp/dep-npm-test')
;

server('prod_1', 'foobar.server')
    ->user('root')
    ->env('deploy_path', '/tmp/dep-npm-test')
    ->stage('production')
    ->forwardAgent()
;
