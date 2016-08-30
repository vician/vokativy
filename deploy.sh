#!/bin/bash

dir=""

if [ $# -eq 1 ]; then
	if [ $1 == "test" ]; then
		dir="test/"
	fi
fi

scp current.sqlite3 vf.vician.cz:/var/www/vokativy.cz/$dir
