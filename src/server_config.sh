#!/bin/bash

if [[ "$#" != 1 ]]; then
    echo 'usage: ./server_config <root_path>'
    exit 1
fi

# change root path in .htaccess configs file
sed "s/ROOT_PATH/$1/" .htaccess > .htaccess_
mv .htaccess_ .htaccess

# change root path in php environment variables
sed "s/ROOT_PATH/$1/" ./templates/env.php > ./templates/env.php_
mv ./templates/env.php_ ./templates/env.php

# change root path in js environment variables
sed "s/ROOT_PATH/$1/" ./js/env.js > ./js/env.js_
mv ./js/env.js_ ./js/env.js
