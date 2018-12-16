#!/bin/bash

if [[ "$#" != 1 ]]; then
    echo 'usage: ./server_config <root_path>'
    exit 1
fi

# change root path in .htaccess configs file
mv .htaccess .htaccess.bak
sed "s/ROOT_PATH/$1/" .htaccess.bak > .htaccess

# change root path in php environment variables
mv ./templates/env.php ./templates/env.php.bak
sed "s/ROOT_PATH/$1/" ./templates/env.php.bak > ./templates/env.php

# change root path in js environment variables
mv ./js/env.js ./js/env.js.bak
sed "s/ROOT_PATH/$1/" ./js/env.js.bak > ./js/env.js
