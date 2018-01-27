@servers(['local'=>'127.0.0.1', 'production'=>'nelson@lipasafe.com'])

{{--Deploy application--}}
@story('deploy')
push-to-git
pull-to-live
build-complete
@endstory

{{--Push local changes to remote Git repo--}}
@task('push-to-git', ['on'=>'local'])
cd /var/www/html/help.lipasafe.dev
git add .
git commit -m "This is an automated deployment"
git push -u origin master
@endtask

{{--Pull new changes from remote repo to VPS --}}
@task('pull-to-live', ['on'=>'production'])
cd /var/www/html/growthpad
git fetch --all
git reset --hard origin/master
composer update
@endtask




@task('rebuild-production', ['on'=>'production'])
cd /var/www/html/growthpad
{{--  composer install  --}}

{{-- Rebuild application --}}
php artisan migrate:refresh --seed
php artisan config:clear
php artisan cache:clear
php artisan route:clear

{{-- Fix permissions --}}
chmod -R 0777 storage

{{-- Rebuild autoload --}}
composer dump-autoload

{{-- Truncate app log --}}
rm storage/logs/laravel.log
touch storage/logs/laravel.log
chmod 0777 storage/logs/laravel.log

{{-- Restart queue workers --}}
php artisan queue:restart

{{--  cd public  --}}
{{--  npm install  --}}

@endtask

@task('build-complete', ['on'=>'local'])
notify-send 'Devops Complete' 'The staging server has been successfully updated'
@endtask