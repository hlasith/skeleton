#!/bin/bash
. /usr/local/bin/jenkinsBashLib

echo " "
echo "#################### S T A R T   B U I L D . S H ####################"
echo " "

#
# Base variables - default
#
GIT_URL="git@github.com:vitapublic/ngl-portal-bundle.git"
COMMIT_URL="https://github.com/vitapublic/ngl-portal-bundle/commit"
SVN_URL_PRODUCTIONCONFIG="https://srv003.intranet.vitapublic-solution.de:8080/svn/config/ngl-portal-bundle/tags"
ENVIRONMENTS=("production" "staging" "new-testing" "development" "bizdev")
NO_PACK=false

#
# get opts (parameter) from jenkins shell commands and override defaults
#
while getopts "e:n:" optname
do
    case "$optname" in
        "e")
            ENVIRONMENT=$OPTARG
            echo_by_verbosity "* PARAM environment: ${OPTARG}"
        ;;
        "n")
            NO_PACK=true
            echo_by_verbosity "* PARAM no pack: ${OPTARG}"
        ;;
    esac
done

# build path for script
BUNDLE_PATH="${WORKSPACE}/${BUILD_NUMBER}/${VERSION}/ngl-portal-bundle.${BUILD_NUMBER}.${VERSION}"

echo " "

#
# Check if environment is empty and set by environment variable
#
if [ "$ENVIRONMENT" == "" ]; then
    ENVIRONMENT=${ENVIRONMENT}
fi

#
# Validate variable ENVIRONMENT
#
if [ "$ENVIRONMENT" == "" ]; then
    echo "* Error: variable environment must be set by using either the -e param of the script or by parameter of a parameters of a parameterized build"
    echo " "
    exit 1
fi
if [ "$ENVIRONMENT" != "production" ] && [ "$ENVIRONMENT" != "staging" ] && [ "$ENVIRONMENT" != "new-testing" ] && [ "$ENVIRONMENT" != "bizdev" ]; then
    echo "* Error: variable environment can only have the values \"production\", \"bizdev\", \"staging\" or \"new-testing\""
    echo " "
    exit 1
fi

#
# Create build directory if not exists
#
echo "* Create build directory ${WORKSPACE}/${BUILD_NUMBER} if not exists"
if [ ! -d ${WORKSPACE}/${BUILD_NUMBER} ]; then
    echo_by_verbosity "* mkdir ${WORKSPACE}/${BUILD_NUMBER}"
    mkdir ${WORKSPACE}/${BUILD_NUMBER}

    if [ $? != 0 ]; then
        echo "* Error: could not create build directory ${WORKSPACE}/${BUILD_NUMBER}"
        echo " "
        exit 1
    fi
fi

#
# Create version directory if not exists
#
echo "* Create version directory ${WORKSPACE}/${BUILD_NUMBER}/${VERSION} if not exists"
if [ ! -d ${WORKSPACE}/${BUILD_NUMBER}/${VERSION} ]; then
    echo_by_verbosity "* mkdir ${WORKSPACE}/${BUILD_NUMBER}/${VERSION}"
    mkdir ${WORKSPACE}/${BUILD_NUMBER}/${VERSION}

    if [ $? != 0 ]; then
        echo "* Error: could not create version directory ${WORKSPACE}/${BUILD_NUMBER}/${VERSION}"
        echo " "
        exit 1
    fi
fi

#
# Export project
#
echo "* Export ngl-portal-bundle from ${GIT_URL}/${VERSION}"
echo_by_verbosity "* git clone ${GIT_URL} ${BUNDLE_PATH}"
git clone ${GIT_URL} ${BUNDLE_PATH}

if [ $? != 0 ]; then
    echo "* Error: could not export ngl-portal-bundle from ${GIT_URL}/${VERSION}"
    echo " "
    exit 1
fi

cd  ${BUNDLE_PATH}
if [ $? != 0 ]; then
    echo "* Error: could not switch directory to ${BUNDLE_PATH}"
    echo " "
    exit 1
fi

git checkout ${VERSION}
if [ $? != 0 ]; then
    echo "* Error: could not switch to ${VERSION}"
    echo " "
    exit 1
fi

#
# Output the exact repository commit that was used for this deploy
#
HEADHASH=$(git rev-parse HEAD)
echo " "
echo "* Used Commit from Repository: ${COMMIT_URL}/${HEADHASH}"
echo " "

cd -
if [ $? != 0 ]; then
    echo "* Error: could not display repository commit"
    echo " "
    exit 1
fi

#
# Get 8 bit md5 hash of HEADHASH
#
echo "* Get 8 bit md5 hash of $HEADHASH"
MD5=$(echo $HEADHASH | cut -c 1-8)
if [ $? != 0 ]; then
  echo "Error: could not get 8 bit md5 hash of $HEADHASH"
  exit 1
fi

#
# Rename BUNDLE_PATH
#
cd ..
mv ${BUNDLE_PATH} ${BUNDLE_PATH}.${MD5}
BUNDLE_PATH="${BUNDLE_PATH}.${MD5}"

#
# Export production config if the ENVIRONMENT variable is "production"
#
if [ "$ENVIRONMENT" == "production" ]; then
    echo "* Export production config from ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}"
    echo_by_verbosity "* /usr/local/bin/jenkinsSvnWrapper export ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/environments/production/system.php ${BUNDLE_PATH}/environments/production/system.php"
    /usr/local/bin/jenkinsSvnWrapper export ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/environments/production/system.php ${BUNDLE_PATH}/environments/production/system.php

    if [ $? != 0 ]; then
        echo "* Error: could not export system.php from ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/environments/production/"
        echo " "
        exit 1
    fi

    echo_by_verbosity "* /usr/local/bin/jenkinsSvnWrapper export ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/app/config/config_prod.yml ${BUNDLE_PATH}/app/config/config_prod.yml"
    /usr/local/bin/jenkinsSvnWrapper export ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/app/config/config_prod.yml ${BUNDLE_PATH}/app/config/config_prod.yml

    if [ $? != 0 ]; then
        echo "* Error: could not export config_prod.yml config from ${SVN_URL_PRODUCTIONCONFIG}/${VERSION}/app/config/"
        echo " "
        exit 1
    fi
fi

#
# Switch to project sourcecode dir
#
echo " "
echo "* Switch directory to ${BUNDLE_PATH}/web"
echo_by_verbosity "* cd ${BUNDLE_PATH}/web"
cd ${BUNDLE_PATH}/web/static
if [ $? != 0 ]; then
  echo "Error: could not switch directory to ${BUNDLE_PATH}/web/static"
  exit 1
fi

#
# Install node modules
#
echo " "
echo "* Install node modules"
/usr/bin/yarn install --frozen-lockfile

#
# see installed modules
#
echo " "
echo "* Install node modules"
cat yarn.lock

#
# Create minified and revisioned css and js
#
echo " "
echo "* Create minified and revisioned css and js"
gruntBuild_by_verbosity build-production

#
# Delete all node_modules except ngl-ui-kit
#
cd node_modules
ls --ignore="ngl-ui-kit" | xargs rm -Rf

#
# switch to workspace directory
#
echo " "
echo "* Switch directory to build directory"
echo_by_verbosity "* cd ${WORKSPACE}/${BUILD_NUMBER}"
cd ${WORKSPACE}/${BUILD_NUMBER}
if [ $? != 0 ]; then
  echo "Error: could not switch directory to ${WORKSPACE}/${BUILD_NUMBER}"
  exit 1
fi

#
# set accessrights
#
echo " "
echo "* Set accessrights"
setAccessRights_by_verbosity ${BUNDLE_PATH}

#
# pack build if NO_PACK equal false
#
if [ "$NO_PACK" == false ]; then
    echo " "
    echo "* Pack build"
    pack_by_verbosity $ENVIRONMENT
fi

echo " "
