#!/usr/bin/env bash

#PATH_TO_FIX=${1:-"./"}

php-cs-fixer --verbose fix #${PATH_TO_FIX}

sleep 2
