#!/bin/bash

modify_files=`git status --porcelain | grep -E '^M|A|R' | awk '{print $NF}' | uniq`
#modify_files=`git status | grep '.php' | awk -F ':' '{print $2}'  | uniq`
for file in ${modify_files}
do
    result=`vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix ${file} --rules=@Symfony --using-cache=no | grep '.php$'`
    echo $result
done
