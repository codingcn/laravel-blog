## 安装步骤
```shell
php artisan migrate

php artisan db:seed

php artisan passport:client --password
```
将生成的密钥与令牌ID填写到.env
```
OAUTH_CLIENT_ID=你的令牌ID
OAUTH_CLIENT_SECRET=你的密钥
OAUTH_SCOPE=*
```
