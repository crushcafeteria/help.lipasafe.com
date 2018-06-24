@servers(['local'=>'127.0.0.1', 'production'=>'root@dock.lipasafe.com'])

{{--Deploy application--}}
@story('deploy')
build
push-to-git
pull-to-live
@endstory

{{--Push local changes to remote Git repo--}}
@task('push-to-git', ['on'=>'local'])
git add .
git commit -m "This is an automated deployment"
git push -u origin master
@endtask

{{--Pull new changes from remote repo to VPS --}}
@task('pull-to-live', ['on'=>'production'])
cd /var/www/help.lipasafe.com
git fetch --all
git reset --hard origin/master
docker-compose down
docker-compose up -d
@endtask

@task('build', ['on'=>'local'])
rm -rf site
mkdocs build --clean
cp -R extras site/images
@endtask
