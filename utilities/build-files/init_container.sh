#!/usr/bin/env bash
cat >/etc/motd <<EOL 
.__  ___________            _________            .___      
|__| \_   _____/______  ___ \_   ___ \  ____   __| _/____  
|  |  |    __)/  _ \  \/  / /    \  \/ /  _ \ / __ |/ __ \/ 
|  |  |     \(  <_> >    <  \     \___(  <_> ) /_/ \  ___/ 
|__|  \___  / \____/__/\_ \  \______  /\____/\____ |\___  >
          \/             \/         \/            \/    \/         
T E C H N I C A L  T E S T  C O N T A I N E R  L I N U X 

EOL
cat /etc/motd

echo "Positioning to /var/www/html ..."
cd /var/www/html

echo "Running seeders..."
php artisan migrate --force \
&& php artisan db:seed --force

echo "Starting ssh..."
# starting sshd process
sed -i "s/SSH_PORT/$SSH_PORT/g" /etc/ssh/sshd_config
/usr/sbin/sshd