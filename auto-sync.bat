@echo off
:: ============================================
:: 🔄 Auto Sync Script - Har 1 minute per
:: ============================================

:loop
cd /d C:\Users\satyam\stripe-course
php artisan sync:pull
timeout /t 60 /nobreak
goto loop
