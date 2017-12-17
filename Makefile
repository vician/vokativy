db=data/db.sqlite3
data=data/data.csv

default: update

backup:
	sqlite3 $(db) ".backup 'data/backup.`date +%F_%T`.sql'"

install:
	sudo apt install php7.1-cli php7.1-mbstring php7.1-sqlite3

download:
	wget -O data/2017-mesicni-aktualizace-zcpr.zip "http://www.mvcr.cz/soubor/2017-mesicni-aktualizace-zcpr-zip.aspx"
	unzip data/2017-mesicni-aktualizace-zcpr.zip -d data/

convert:
	iconv -f WINDOWS-1250 -t UTF-8 data/zcpr.csv > data/data.csv
	# odstranit uvozovky
	sed -i  's/"//g' data/data.csv
	# odstranit ,0
	sed -i "s/,0;//g" data/data.csv

init:
	rm -f $(db)
	sqlite3 $(db) < sql/init.sql

update: backup init
	sqlite3 -separator ';' $(db) ".import data/data.csv surnames"
	sqlite3 $(db) < sql/rules.sql
	./sql/exceptions.sh
	php stats.php > stats.html

start:
	php -S localhost:9002

clean:
	rm data/*
