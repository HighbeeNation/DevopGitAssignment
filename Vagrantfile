
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
 sudo service apache2 restart
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
 sudo sed -i "s/.bind-address./bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
 sudo systemctl restart mysql
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
  web.vm.provision "file", source: "index.php", destination: "~/"
  web.vm.provision "shell" , inline: $script_web
  end

  config.vm.define "db" do |db|
    db.vm.hostname = "db"
    db.vm.network "private_network", ip: "172.28.128.4"
    db.vm.provision "shell" , inline: $script_db
    end

  
end