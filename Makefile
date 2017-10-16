install:
	sudo apt install gnumeric

download:
	wget -O data/2017-mesicni-aktualizace-zcpr.zip "http://www.mvcr.cz/soubor/2017-mesicni-aktualizace-zcpr-zip.aspx"
	unzip data/2017-mesicni-aktualizace-zcpr.zip -d data/
	iconv -f ISO-8859-1 -t UTF-8 data/zcpr.csv > data/data.csv

clean:
	rm data/*
