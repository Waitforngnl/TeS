# Setup dự án
1. **Clone dự án (làm 1 lần):**
```shell
git clone https://github.com/Waitforngnl/TeS.git
cd TeS
```
2. **Cấu hình:**
Tạo file .env từ file .env.example (hoặc đổi tên)
```shell
composer install
npm install
npm run build
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan serve
```

**Reset Database**  
```shell
php artisan migrate:fresh --seed
```

