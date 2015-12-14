#!/bin/sh

run() {
    echo -n "\033[s"
    echo -n "- $@"
    ($@ 2>&1; echo $?>~/_$$) | log
    echo -n "\033[u"
    echo -n "\033[1A"
    if test 0 -eq $(cat ~/_$$;rm ~/_$$); then
        echo "\033[1;32m✓ \033[0m"
    else
        echo "\033[1;31m✕ \033[0m"
    fi
}

log() {
   while read line; do
       echo -n "."
   done
   echo
}
