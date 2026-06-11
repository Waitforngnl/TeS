# to-do  
- Thêm cái khi bấm vào products card sẽ show detailed info
- Thêm AI chatbox icon góc dưới phải

# Setup dự án
1. **Clone dự án (làm 1 lần):**
```shell
git clone
cd laravel-final
```
2. **Cấu hình:**
```shell
cp .env.example .env
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

3. **Các nhánh trong dự án:**
- `main` : Nhánh chính, dùng để tổng hợp lại và để nộp bài.
- `frontend` : Nhánh làm giao diện (UI).
- `backend` : Nhánh xử lý logic + database.

