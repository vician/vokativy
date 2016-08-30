#!/bin/bash

url=""
filename=""
base_url="http://www.mvcr.cz"
origin="$base_url/clanek/cetnost-jmen-a-prijmeni-722752.aspx"

data=$(wget -qO- $origin | grep stobyv)
#data='    <li><a href="soubor/stobyv-20160803-zip.aspx" title="stobyv_20160803.zip">Přehled četnosti všech příjmení</a>&nbsp;(zip,&nbsp;4,2&nbsp;MB) (aktualizováno k 3. 8.&nbsp;2016)<br /><strong>&nbsp;</strong></li>'

pre_url=$(echo $data | grep -oh "href=\"soubor/stobyv-[[:alnum:]]*-zip\.aspx\"")
pre_filename=$(echo $data | grep -oh "title=\"stobyv_[[:alnum:]]*\.zip\"")

url=$(echo $pre_url | awk -F'"' '{print $2}')
filename=$(echo $pre_filename | awk -F'"' '{print $2}')

wget -O $filename $base_url/$url

bash init.sh $filename
