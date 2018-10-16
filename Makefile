db=data/db.sqlite3
csv=data/zcpr.csv
data=data/data.csv

default: update

backup:
	sqlite3 $(db) ".backup 'data/backup.`date +%F_%T`.sql'"

install:
	sudo apt install php7.2-cli php7.2-mbstring php7.2-sqlite3

download:
	wget -O data/2017-mesicni-aktualizace-zcpr.zip "http://www.mvcr.cz/soubor/2017-mesicni-aktualizace-zcpr-zip.aspx"
	unzip data/2017-mesicni-aktualizace-zcpr.zip -d data/

convert:
	iconv -f WINDOWS-1250 -t UTF-8 $(csv) > $(data)
	# odstranit uvozovky
	sed -i  's/"//g' $(data)
	# odstranit ,0
	sed -i "s/,0;//g" $(data)

init:
	rm -f $(db)
	sqlite3 $(db) < sql/init.sql

update: download backup init convert
	sqlite3 -separator ';' $(db) ".import data/data.csv surnames"
	sqlite3 $(db) < sql/rules.sql
	./sql/exceptions.sh
	php stats.php > stats.html

start:
	php -S localhost:8102

clean:
	rm data/*
