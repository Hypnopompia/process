#!/bin/bash
# this script just reads stdin and echos back out to stdout until stdin is closed
while read x ; do echo $x ; done
