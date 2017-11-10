#!/bin/sh
# By default we use the Node.js version set in your package.json or the latest
# version from the 0.10 release
#
# You can use nvm to install any Node.js (or io.js) version you require.
# nvm install 4.0
# Install grunt-cli for running your tests or other tasks
phpenv local 7.0
#npm update
#npm install -g grunt-cli
#npm rebuild node-sass
#bower update
#grunt scan
#grunt build

composer install
composer update
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; put -O / index.php"
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; put -O / .htaccess"
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git src/ /src"
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git app/ /app"
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git lib/ /lib"
# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R --parallel=2 --exclude-glob .git dist/ /dist"

curl "http://www.pichku.com/?RX_MODE_DEBUG=true&RX_MODE_BUILD=1"


# lftp -c "open -u $FTP_WEB_USER,$FTP_WEB_PASSWORD $FTP_WEB_SERVER; set ssl:verify-certificate no; mirror -R no/ /no"
ssh_connection='ubuntu@35.154.54.97'
cd ~
echo 'Making "orderservice.modestreet.in"..'
mkdir -p productservicegz
echo "Copying clone to orderservicegz.."
cp -r clone/*  orderservicegz/
echo "Compressing using tar.."
tar -czf orderservicegz.tar.gz orderservicegz
echo "Transferring file to " $ssh_connection ".."
rsync -avz --progress orderservicegz.tar.gz $ssh_connection:/var/www/
echo "Cleaning up.."
ssh $ssh_connection 'cd /var/www/ && tar -xzf orderservicegz.tar.gz && rsync -a orderservicegz/* orderservice.modestreet.in/ --chown=ubuntu:ubuntu && rm -f orderservicegz.tar.gz && rm -fr orderservicegz && orderservicegz'
