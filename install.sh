#!/bin/bash
. /usr/local/bin/jenkinsBashLib

echo " "
echo "#################### S T A R T   I N S T A L L . S H ####################"

#
# get opts
#
while getopts "e:v:r:" optname; do
    case "$optname" in
        "e")
            ENVIRONMENT=$OPTARG
        ;;
        "v")
            VERSION=$OPTARG
        ;;
        "r")
            REBUILD=$OPTARG
        ;;
    esac
done

BUNDLEDIRECTORY=$(dirname $(readlink -f $0))
CMSDIRECTORY=$(readlink -f /var/www/pimcore)

if [ "$ENVIRONMENT" == "bizdev" ]; then
    NGINXCONFDESTINATION=/etc/nginx/conf.d/c_ngl-bizdev.test.vitapublic.de.conf
    PHPFPMCONFDESTINATION=/etc/php-fpm.d/c_ngl-bizdev.test.vitapublic.de.conf
    CRONCONFDESTINATION=/etc/cron.d/90_ngl-bizdev.test.vitapublic.de.conf
    NORMALIZEDENV=bizdev
    PIMCOREENV=bizdev
fi

if [ "$ENVIRONMENT" == "new-testing" ]; then
    NGINXCONFDESTINATION=/etc/nginx/conf.d/c_ngl-new.test.vitapublic.de.conf
    PHPFPMCONFDESTINATION=/etc/php-fpm.d/c_ngl-new.test.vitapublic.de.conf
    CRONCONFDESTINATION=/etc/cron.d/90_ngl-new.test.vitapublic.de.conf
    NORMALIZEDENV=newtesting
    PIMCOREENV=newtesting
fi

if [ "$ENVIRONMENT" == "production" ]; then
    NGINXCONFDESTINATION=/etc/nginx/conf.d/c_www.ngl.one.conf
    PHPFPMCONFDESTINATION=/etc/php-fpm.d/c_www.ngl.one.conf
    CRONCONFDESTINATION=/etc/cron.d/90_www.ngl.one.conf
    NORMALIZEDENV=production
    PIMCOREENV=prod
fi

echo " "
echo "* BUNDLEDIRECTORY is: ${BUNDLEDIRECTORY}"
echo "* CMSDIRECTORY is:    ${CMSDIRECTORY}"

#
# Symlink bundle
#
echo " "
echo "Symlink bundle"

# Symlink environment config in pimcore/app/config
unlink $CMSDIRECTORY/app/config/config_$PIMCOREENV.yml
ln -s $BUNDLEDIRECTORY/app/config/config_$PIMCOREENV.yml $CMSDIRECTORY/app/config/config_$PIMCOREENV.yml

# Symlink view folder in pimcore/app/Resources
if [[ -L "$CMSDIRECTORY/app/Resources/views" ]]; then
    unlink $CMSDIRECTORY/app/Resources/views
else
    rm -Rf $CMSDIRECTORY/app/Resources/views
fi
ln -s $BUNDLEDIRECTORY/app/Resources/views $CMSDIRECTORY/app/Resources/views

# Symlink migrations folder in pimcore/app/Resources
if [[ -L "$CMSDIRECTORY/app/Resources/migrations" ]]; then
    unlink $CMSDIRECTORY/app/Resources/migrations
fi
ln -s $BUNDLEDIRECTORY/app/Resources/migrations $CMSDIRECTORY/app/Resources/migrations

# Symlink AppBundle folder in pimcore/src
if [[ -L "$CMSDIRECTORY/src/AppBundle" ]]; then
    unlink $CMSDIRECTORY/src/AppBundle
else
    rm -Rf $CMSDIRECTORY/src/AppBundle
fi
ln -s $BUNDLEDIRECTORY/src/AppBundle $CMSDIRECTORY/src/AppBundle

# Symlink classes folder in pimcore/var
if [[ -L "$CMSDIRECTORY/var/classes" ]]; then
    unlink $CMSDIRECTORY/var/classes
else
    rm -Rf $CMSDIRECTORY/var/classes
fi
ln -s $BUNDLEDIRECTORY/var/classes $CMSDIRECTORY/var/classes

# Symlink config folder in pimcore/var
if [[ -L "$CMSDIRECTORY/var/config" ]]; then
    unlink $CMSDIRECTORY/var/config
else
    rm -Rf $CMSDIRECTORY/var/config
fi
ln -s $BUNDLEDIRECTORY/var/config $CMSDIRECTORY/var/config

# Symlink static folder in pimcore/web
if [[ -L "$CMSDIRECTORY/web/static" ]]; then
    unlink $CMSDIRECTORY/web/static
fi
ln -s $BUNDLEDIRECTORY/web/static $CMSDIRECTORY/web/static

# Symlink system.php in pimcore/var/config
unlink $CMSDIRECTORY/var/config/system.php
ln -s $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/system.php $CMSDIRECTORY/var/config/system.php

# Symlink debug-mode.php in pimcore/var/config
unlink $CMSDIRECTORY/var/config/debug-mode.php
ln -s $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/debug-mode.php $CMSDIRECTORY/var/config/debug-mode.php

#
# Rebuild classes
#
echo " "
echo "Rebuild classes"

$CMSDIRECTORY/bin/console pimcore:deployment:classes-rebuild --env=$PIMCOREENV

#
# Symlink configs
#
echo " "
echo "Symlink configs"

unlink $NGINXCONFDESTINATION
ln -s $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/nginx.conf $NGINXCONFDESTINATION
unlink $PHPFPMCONFDESTINATION
ln -s $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/php-fpm-pool.conf $PHPFPMCONFDESTINATION
unlink $CRONCONFDESTINATION
ln -s $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/cron.conf $CRONCONFDESTINATION

#
# Migration
#
echo " "
echo "Trigger Migration"

$CMSDIRECTORY/bin/console cache:clear --no-interaction --env=$PIMCOREENV
$CMSDIRECTORY/bin/console pimcore:migrations:status --env=$PIMCOREENV
$CMSDIRECTORY/bin/console pimcore:migrations:migrate --no-interaction --env=$PIMCOREENV
$CMSDIRECTORY/bin/console cache:clear --no-interaction --env=$PIMCOREENV
$CMSDIRECTORY/bin/console pimcore:cache:clear --no-interaction --env=$PIMCOREENV
$CMSDIRECTORY/bin/console pimcore:cache:warming --env=$PIMCOREENV

chown -R nginx:nginx $CMSDIRECTORY
chown -R nginx:nginx $BUNDLEDIRECTORY
chmod 0644 $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/cron.conf
chown root:root $BUNDLEDIRECTORY/environments/$NORMALIZEDENV/cron.conf

#
# Restart php-fpm
#
if [ "$PHPFPMCONFDESTINATION" != "" ]; then
  echo " "
  echo "* test + restart php-fpm"
  echo " "
  service php-fpm configtest
  # missing error handling @todo
  service php-fpm reload
fi

#
# Restart webserver
#
if [ "$NGINXCONFDESTINATION" != "" ]; then
  echo " "
  echo "* test + restart nginx"
  echo " "
  service nginx configtest
  # missing error handling @todo
  service nginx reload
fi

#
# Restart webserver
#
if [ "$CRONCONFDESTINATION" != "" ]; then
  echo " "
  echo "* test + restart cron"
  echo " "
  #service nginx configtest @todo
  # missing error handling @todo
  service crond reload
fi
