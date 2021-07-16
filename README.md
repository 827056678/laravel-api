## Laravel Api

复制 .env.example 为 .env
修改数据库配置

-   [composer update].
-   [php artisan key:generate].
-   [php artisan jwt:secret].
-   [php artisan migrate:refresh --seed].

## Login

POST {your host}/api/v1/login {email:'827056678@qq.com',password:'password'}

## User

RESOURCE {your host}/api/v1/users
