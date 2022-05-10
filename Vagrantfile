
 $script_web = <<-SCRIPT 
 sudo apt-get update -y
 sudo apt install php libapache2-mod-php php-mysql -y
 sudo apt install php7.4-mysqli
 sudo apt-get install apache2 -y
 sudo apt-get install mysql-client -y
 sudo ufw enable -y
 sudo ufw allow http
 sudo ufw allow ssh
 sudo ufw allow mysql
 sudo mkdir /var/www/Tampa

 sudo chown -R $USER:$USER /var/www/Tampa
 
 sudo a2ensite Tampa
 sudo service apache2 restart
 sudo nano /etc/apache2/mods-enabled/dir.conf
 sudo systemctl reload apache2
 cp -r /data/. /var/www/html
 rm /var/www/html/index.html
 SCRIPT

 # rm /var/www/html/index.html

 $script_db = <<-SCRIPT 
 sudo apt-get update -y
 sudo apt-get install mysql-server -y
 echo y | sudo ufw enable
 sudo ufw allow mysql
 sudo ufw allow ssh
 mysql < /data/mysql_script.sql
 sudo sed -i "s/.bind-address./bind-address = 172.28.128.4/" /etc/mysql/mysql.conf.d/mysqld.cnf
 sudo systemctl restart mysql
 CREATE USER 'Florida'@'172.28.128.4' IDENTIFIED BY 'April@2022';
 GRANT CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT, REFERENCES, RELOAD on *.* TO 'Florida'@'172.28.128.4' WITH GRANT OPTION;
 mysql -uroot -p$DBPASSWD -e "CREATE DATABASE $DBNAME"
 mysql -uroot -p$DBPASSWD -e "grant all privileges on $DBNAME.* to 'Florida'@'localhost' identified by 'April@2022'"
 sudo ufw allow from 172.28.128.4 to any port 3306
 sudo ufw allow 3306
 DBHOST=localhost
 DBNAME=Fenty
 DBUSER=Kaduna
 DBPASSWD=April@2022
 SCRIPT

 Vagrant.configure("2") do |config|
  config.vm.box = "bento/ubuntu-20.04"
  config.vm.synced_folder ".", "/data"
  config.vm.provider "virtualbox" do |v|
    v.linked_clone = true
    v.memory = 1024
    v.cpus = 1
  end

  config.vm.define "web" do |web|
  web.vm.hostname = "webserver"
  web.vm.network "private_network", ip: "172.28.128.3"
  web.vm.provision "file", source: "index.php", destination: "/home/vagrant/todo_list.php"
  #web.vm.provision "file", source: "configurationfile", destination: "/etc/apache2/sites-available/Tampa.conf"
  #web.vm.provision "shell" , inline: $script_web
  end

  config.vm.define "db" do |db|
    db.vm.hostname = "db"
    db.vm.network "private_network", ip: "172.28.128.4"
    db.vm.provision "shell" , inline: $script_db
    end

  
end