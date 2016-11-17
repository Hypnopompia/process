#!/bin/bash
echo "START $1"
# sleep $[ ( $RANDOM % 5 )  + 1 ]s
>&2 echo "DUR $1"
sleep $[ ( $RANDOM % 5 )  + 1 ]s
echo "END $1"

exit 2