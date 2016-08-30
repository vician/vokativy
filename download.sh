#!/bin/bash

# Needed
url=""
filename=""

base_url="http://www.mvcr.cz"
origin="$base_url/clanek/cetnost-jmen-a-prijmeni-722752.aspx"

data=$(wget -qO- $origin | grep stobyv)
if [ $? -ne 0 ]; then
	echo "Cannot download source page!"
	exit 0
fi

pre_url=$(echo $data | grep -oh "href=\"soubor/stobyv-[[:alnum:]]*-zip\.aspx\"")
if [ $? -ne 0 ]; then
	echo "Cannot get URL"
	exit 0
fi
pre_filename=$(echo $data | grep -oh "title=\"stobyv_[[:alnum:]]*\.zip\"")
if [ $? -ne 0 ]; then
	echo "Cannot get filename!"
	exit 0
fi

url=$(echo $pre_url | awk -F'"' '{print $2}')
if [ $? -ne 0 ]; then
	echo "UNKNOW: Wrong URL"
	exit 0
fi
filename=$(echo $pre_filename | awk -F'"' '{print $2}')
if [ $? -ne 0 ]; then
	echo "UNKNOW: Wrong filename"
	exit 0
fi

wget -O $filename $base_url/$url
if [ $? -ne 0 ]; then
	echo "Cannot download zip!"
	exit 0
fi

bash init.sh $filename
