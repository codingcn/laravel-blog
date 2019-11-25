## 项目简介
* 基于Laravel5.5+VueJS2.x实现的Blog
* 后台采用前后端完全分离（SPA）开发


## 安装步骤
### 1. 获取项目
```
git clone https://github.com/codingcn/blog.git

cd blog
npm i
npm run prod
composer install

cp .env.example .env
```
### 2. 修改`.env`中的数据库信息以及邮件服务器信息（github登录）

### 3. 建立目录链接及数据初始化
```shell
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed
```
### 4. 配置passport
```
php artisan passport:keys
php artisan passport:client --personal
# 可以直接回车
```
### 5. 设置目录及文件权限
```
# 进入项目的上层目录
cd ../
sudo chown -R www:www blog/
sudo find blog/ -type f -exec chmod 644 {} \;
sudo find blog/ -type d -exec chmod 755 {} \;
sudo chmod -R 777 blog/storage
sudo chmod -R 777 blog/bootstrap/cache
```
### 6. 测试
后台访问：ServerName/admin
账号：`admin`
密码：`123456`

