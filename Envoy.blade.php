@servers(['web' => '127.0.0.1'])

@task('deploy')
    cd /path/to/site
    git pull origin master
@endtask
