# 社内管理


社内管理画面のソースリポジトリ

## ユニットテスト

```bash
cd /path/to/internal_mng/wifi_internal_mng
php oil test
```

## ローカル開発環境の立ち上げ

### 動作確認環境

- Windows10
- VirtualBox: 6.0.14
- vagrant: 2.2.5

### ミドルウェア

- php
```bash
PHP 7.3.11 (cli) (built: Oct 22 2019 08:11:04) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.11, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.11, Copyright (c) 1999-2018, by Zend Technologies
```
- apache
```bash
Server version: Apache/2.4.6 (CentOS)
Server built:   Aug  8 2019 11:41:18
```
- MySQL
```bash
/usr/sbin/mysqld  Ver 8.0.18 for Linux on x86_64 (MySQL Community Server - GPL)
```

### オールインワンBOX

[こちらから最新を取得してください](https://drive.google.com/drive/u/1/folders/1--uiXVBcR89tJNci9XK0-vOnHtu_EFpf)


### 構築手順

1. 取得したboxを登録する
```bash
vagrant.exe box add --name hl/centos7-aio-box /path/to/box
```
2. 本リポジトリをcloneする
```bash
git clone ${this repository}
```
3. ディレクトリ直下に移動する
```bash
cd sales_mng/
```
4. vbguestをインストールする
```bash
vagrant plugin install vagrant-vbguest
```
5. 仮想環境を立ち上げる
```bash
vagrant up
```

### 有効なURL

- http://192.168.10.10/mng/
  - とりあえずでトップ画面にアクセスするURL
- http://192.168.10.10:1080
  - メールキャッチャーのURL
  - 動作確認していないけどメールはここに届くはず

### （備考）BOX構成
```
### CentOSの初期設定
yum -y upgrade
sed -i -e "s/^SELINUX=enforcing$/SELINUX=disabled/g" /etc/selinux/config
localectl set-locale LANG=ja_JP.utf8
timedatectl set-timezone Asia/Tokyo

### 趣味(消し忘れたけどきっと必要です。ansibleはないと思いますが)
yum -y install bash-completion vim
yum -y install ansible
ansible-galaxy init human_role

### とりあえずyumでPHPをインストール
yum -y install epel-release zip libzip libzip-devel unzip
rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
yum -y install --enablerepo=remi,remi-php73 php php-devel php-mbstring php-pdo php-gd php-opcache php-openssl phpunit php-mysqlnd
curl -sS https://getcomposer.org/installer | php -- --install-dir=/tmp
mv /tmp/composer.phar /usr/local/bin/composer

### apacheもyumでインストール
systemctl stop httpd
yum -y remove httpd
yum -y remove httpd-tools
yum -y install "https://centos7.iuscommunity.org/ius-release.rpm"
yum -y install --enablerepo=ius httpd httpd-devel mod_ssl
systemctl enable httpd.service

### MySQLもyumでインストール
yum -y remove mariadb-libs
rpm -ivh "https://dev.mysql.com/get/mysql80-community-release-el7-3.noarch.rpm"
yum -y install mysql-community-server
systemctl enable mysqld.service
echo "validate_password.policy=LOW" >> /etc/my.cnf
systemctl restart mysqld
mysql_secure_installation
mysql -uroot -p
# => rootroot

### ディレクトリは一旦こんな感じで
mkdir -p /home/www/rw/{sales_mng/session,tmp/cache,tmp/file}
chmod -R 775 /home/www
chown -R vagrant:vagrant /home/www
mkdir -p /home/log/{php_app,httpd,mysql}
chmod -R 777 /home/log

### mailcatcher入れた(boxの肥大化の原因)
yum -y install ruby ruby-devel gcc gcc-c++ sqlite-devel
gem install mailcatcher
```
