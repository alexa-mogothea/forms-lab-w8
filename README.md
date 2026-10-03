# Week 8 – Forms & Validation (finished Course project)

1. composer create-project laravel/laravel forms-lab-w8
2. cd forms-lab-w8   (confirm .env has DB_CONNECTION=sqlite)
3. Put the w8-overlay folder next to forms-lab-w8, then from inside forms-lab-w8:
      bash ../w8-overlay/install.sh        (macOS/Linux/Git Bash)
   Without bash (PowerShell): copy the app, database, resources and routes
   folders into the project (overwrite when asked), then run:
      php artisan storage:link
      php artisan migrate:fresh --seed
4. php artisan serve  ->  http://127.0.0.1:8000/courses
