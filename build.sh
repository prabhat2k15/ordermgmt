#!/bin/sh
# By default we use the Node.js version set in your package.json or the latest
# version from the 0.10 release
#
# You can use nvm to install any Node.js (or io.js) version you require.
# nvm install 4.0
# Install grunt-cli for running your tests or other tasks

npm update
npm install -g grunt-cli
npm rebuild node-sass
bower update
grunt scan
grunt build

composer install
composer update
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; put -O / index.php"
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; put -O / .htaccess"
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git src/ /src"
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git app/ /app"
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git lib/ /lib"
lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git dist/ /dist"

curl "http://www.pichku.com/?RX_MODE_DEBUG=true&RX_MODE_BUILD=1"

lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R no/ /no"


