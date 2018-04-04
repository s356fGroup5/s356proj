
# Run xampp in docker

# The directory that the script currently is in
PROJDIR="$( cd "$( dirname "${BASH_SOURCE[0]}/" )" && cd .. && pwd )"

docker run -d --rm \
    --name xampp \
    -p 8000:80 \
    -v $PROJDIR:/www \
    -v $PROJDIR/docker/php.ini:/opt/lampp/etc/php.ini \
    -v $PROJDIR/docker/httpd.conf:/opt/lampp/apache2/conf/httpd.conf \
    tomsik68/xampp
