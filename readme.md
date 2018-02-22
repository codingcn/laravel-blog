## 项目简介
* 基于Laravel5.5+VueJS2.x实现的Blog
* 后台采用前后端完全分离（SPA）开发


## 安装步骤
### 1. 获取项目
```
git clone https://github.com/codingcn/blog.git
cd blog
cp .env.example .env

npm install
npm run prod
composer install
```
### 2. 修改`.env`中的数据库信息以及邮件服务器信息
```

```
### 3. 建立目录链接及数据初始化
```shell
php artisan storage:link
php artisan migrate
php artisan db:seed
```
### 4. 配置passport
```
php artisan passport:keys
php artisan passport:client --password
# 可以直接回车
```
将生成的密钥与令牌ID填写到.env
```
OAUTH_CLIENT_ID=你的令牌ID
OAUTH_CLIENT_SECRET=你的密钥
OAUTH_SCOPE=*
```
### 5. 测试
后台访问：ServerName/admin
账号：`admin`
密码：`123456`

