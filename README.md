# Pratical Test 
```bash
.__  ___________            _________            .___      
|__| \_   _____/______  ___ \_   ___ \  ____   __| _/____  
|  |  |    __)/  _ \  \/  / /    \  \/ /  _ \ / __ |/ __ \
|  |  |     \(  <_> >    <  \     \___(  <_> ) /_/ \  ___/ 
|__|  \___  / \____/__/\_ \  \______  /\____/\____ |\___  >
          \/             \/         \/            \/    \/         
T E C H N I C A L  T E S T  C O N T A I N E R  L I N U X 
```

This commands are helpers to start an environment with docker for technical-test.

## Installation
Before starting make sure you have created a local MySQL database technical_test encoded in UTF8-mb4. Now in you admin console replace the content of variables starting with $ by the appropriate value and use the command [docker](https://www.docker.com/get-started) to build the container. 
```bash
docker build -t $IMAGE_NAME --no-cache .
```
### Description of variables
$IMAGE_NAME is the image name. Example technical-test:latest.  
$CONTAINER_ID is the container name. Example f42199966c22 .  
## Usage
 Use this command to create a docker container
```bash
# run image
docker run -d -p 80:80 $IMAGE_NAME

# retreive container
docker ps -a

# enter the container
docker exec -it $CONTAINER_ID bash
```

### Change database host in env file
Update the env.example file in project with valid values copy paste and rename it to .env
```bash
# add environment file with values
cp .env.example .env

# update .env file
nano .env
```
Change database hosts to [host.docker.internal](#) be able to connect with local databases.

Update this
```
APP_ENV=XXXXX
DB_HOST=XXXXX
MIX_ASSET_URL=XXXXX
ASSET_URL=XXXXX
```
to this
```
APP_ENV=local
DB_HOST=host.docker.internal
MIX_ASSET_URL=http://localhost/public
ASSET_URL=http://localhost/public
```
### Execute commands
Clear the cache and restart apache service. Use the ip address displayed by apache service after resarting it in the browser.If no error appear and the index page appear succesfully you are ready to go. If not please review carefully previous steps.
```bash
# refresh the cache
php artisan config:cache

# run the migrations
php artisan migrate --force

# dump autoload files
composer dump-autoload

# seed the database
php artisan db:seed --force

# generate application
php artisan key:generate
```
### Application access
After all successfull steps the application will be accessible on http://localhost

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## Link to repository
[Repository](https://github.com/charlextra/technical-test)
