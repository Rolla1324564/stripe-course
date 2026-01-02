# 🚀 RENDER DATABASE SEEDING GUIDE

## Option 1: Render Dashboard से करो
1. Render Dashboard खोलो: https://dashboard.render.com
2. अपना "stripe-course" web service खोलो
3. "Shell" tab पर जाओ
4. यह commands run करो:

```bash
cd /var/www/html
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder
```

---

## Option 2: Via SSH (अगर उपलब्ध हो)
```bash
ssh your-render-service.onrender.com
cd /var/www/html
php artisan db:seed
```

---

## Option 3: Wait for auto-sync (1-2 hours)
जब तक Render पूरी तरह deploy न हो जाए, push command काम नहीं करेगा।

---

## Check करने के लिए:
```bash
# Render dashboard खोल के check करो
curl https://stripe-course-1.onrender.com/api/export/courses
```

अगर JSON data दिखता है = Routes काम कर रहे हैं
अगर 404 दिखता है = Render अभी deploy हो रहा है
