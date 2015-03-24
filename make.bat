If "%1"=="" GOTO INFO
If "%1"=="install" GOTO INSTALL
If "%1"=="update" GOTO UPDATE
If "%1"=="dev" GOTO DEV
If NOT "%1"=="" GOTO INFO

:INSTALL
    md "web/uploads"
    call composer install
    echo composer done
    call npm install
    echo npm done
    call bower install
    echo bower done
    php app/console assets:install
    echo assets done
    call gulp build
    echo gulp done
    php app/console doctrine:schema:drop --force
    echo drop done
    php app/console doctrine:schema:create
    echo create done
    php app/console doctrine:fixtures:load -n
    echo fixtures done
    php app/console cache:clear
    echo clastic install is finished
    GOTO DONE
:UPDATE
    call composer install
    echo composer done
    call npm install
    echo npm done
    call bower install
    echo composer done
    php app/console assets:install
    echo assests done
    call gulp build
    echo gulp done
    php app/console doctrine:schema:update --force
    echo update done
    php app/console doctrine:fixtures:load
    echo fixtures done
    php app/console cache:clear
    echo clastic update is finished
    GOTO DONE
:DEV
    php app/console assets:install --symlink
    gulp watch & php app/console server:run
    GOTO DONE
:DONE
    echo clastic is finished
    GOTO END
:INFO
    @ECHO OFF
    echo make install  ( = install clastic)
    echo make update ( = update clastic)
    echo make dev  ( = start local server on port 8000)
:END
    @ECHO ON
