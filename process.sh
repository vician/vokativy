#!/bin/bash

if [ $# -ne 1 ]; then
	echo "Spatne parametr!"
	echo "Ma byt: $0 zip_file"
	echo "Zip ke stazeni na: http://www.mvcr.cz/clanek/cetnost-jmen-a-prijmeni-722752.aspx"
	echo "Odkaz: Přehled četnosti všech příjmení"
	exit 1
fi

zip=$1

unzip $zip

input=$(echo $zip | sed 's/\.zip$/.xls/' | sed 's/-/_/g')

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

sqlite3 $input.sqlite3 < rules.sql

rm $input.csv*
rm $input
