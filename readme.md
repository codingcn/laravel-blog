## 安装步骤
### 1. 获取项目
```
git clone https://github.com/codingcn/blog.git
cd blog
npm install
composer install
```
### 2. 修改`.env`中的数据库信息以及邮件服务器信息
```shell
php artisan storage:link

php artisan migrate

php artisan db:seed
php artisan passport:keys
php artisan passport:client --password
```
将生成的密钥与令牌ID填写到.env
```
OAUTH_CLIENT_ID=你的令牌ID
OAUTH_CLIENT_SECRET=你的密钥
OAUTH_SCOPE=*
```
