#!/bin/bash

DATA="sql/exceptions.txt"
separator=","

DB="data/db.sqlite3"

while IFS='' read -r line || [[ -n "$line" ]]; do
	nominativ=$(echo $line | awk -F "$separator" '{print $1}' | awk '{print toupper($0)}' )
	vokativ=$(echo $line | awk -F "$separator" '{print $2}' | awk '{print toupper($0)}' )
	echo "'$nominativ' -> '$vokativ'"

	sqlite3 $DB "UPDATE surnames SET vokativ = '$vokativ', rule = 'v' WHERE surname = '$nominativ';"
done < "$DATA"
