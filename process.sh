#!/bin/bash

if [ $# -ne 1 ]; then
	echo "Wrong arguments, should be: $0 xls_file"
	exit 1
fi

#@todo unzip $1
input=$1

which ssconvert 1>/dev/null 2>/dev/null
if [ $? -ne 0 ]; then
	echo "ssconvert not found, please install gnumeric!"
	exit 1
fi

rm $input.csv*

ssconvert -S $input $input.csv

ls $input.csv*

rm $input.sqlite3
sqlite3 $input.sqlite3 < init.sql

# Odstranit uvozovky
sed -i 's/"//g' $input.csv*

for f in $input.csv*; do
	sqlite3 $input.sqlite3	<<< ".separator ','
.import $f surnames
"
#	sqlite3 $input.sqlite3	".import $f surnames"
done

# Odstranit PŘÍJMENÍ
sqlite3 $input.sqlite3 "DELETE FROM surnames WHERE surname = 'PŘÍJMENÍ'"
sqlite3 $input.sqlite3 "DELETE FROM surnames WHERE surname = 'SOUČET'"
# Odstranit SOUČET
