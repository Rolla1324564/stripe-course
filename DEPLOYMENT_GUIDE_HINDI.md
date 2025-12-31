# 🌐 Project को अपने Dummy Server पर Host करने का Complete Guide

---

## 📋 HOSTING OPTIONS (कौन सा option चुनें?)

| Option | Cost | Setup | Speed | Best For |
|--------|------|-------|-------|----------|
| **Local Server** | FREE | 5 min | ⚡ Fast | Development |
| **Ngrok Tunnel** | FREE | 2 min | 🟡 Good | Testing & Sharing |
| **AWS/Azure** | Paid | 30 min | ⚡⚡ Very Fast | Production |
| **Shared Hosting** | Cheap | 10 min | 🟡 Average | Small Projects |
| **VPS** | Medium | 20 min | ⚡ Fast | Growing Projects |

---

## 🔷 OPTION 1: Local Server (सबसे आसान - आपका computer ही server)

### **क्या है?**
आपका computer ही एक server बन जाता है। दूसरे devices उसे access कर सकते हैं।

### **कैसे करें?**

#### **Step 1: Terminal खोलो और project folder में जाओ**
```powershell
cd c:\Users\satyam\stripe-course
```

#### **Step 2: Composer dependencies install करो**
```powershell
composer install
```

#### **Step 3: Database setup करो**
```powershell
php artisan migrate
php artisan db:seed
```

#### **Step 4: Server को सभी devices से accessible बनाओ**
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

**Output:**
```
✓ Laravel development server started: http://0.0.0.0:8000
```

#### **Step 5: Access करो**

**अपने computer से:**
```
http://localhost:8000
http://127.0.0.1:8000
```

**दूसरे device से (same network):**
```
http://<YOUR_COMPUTER_IP>:8000

Example: http://192.168.0.5:8000
```

#### **अपना Computer IP कैसे जानो?**

**Windows:**
```powershell
ipconfig
```

Output में ढूंढो:
```
IPv4 Address: 192.168.0.5  ← यही use करो
```

**या simply:**
```powershell
Write-Host $env:COMPUTERNAME
# फिर Local Network में उस computer को ping करो
```

---

## 🔷 OPTION 2: Ngrok Tunnel (FREE - 1 Min Setup)

### **क्या है?**
एक tool जो आपके local server को internet पर accessible बना देता है। बिना port forward किए!

### **Installation:**

#### **Step 1: Ngrok download करो**
```
Website: https://ngrok.com
Download करो (Windows 64-bit)
```

#### **Step 2: Extract करो और System में add करो**

1. Download की गई zip file को extract करो
2. `ngrok.exe` को move करो: `C:\Users\satyam\AppData\Local\Programs\ngrok\`

#### **Step 3: Terminal खोलो और ngrok setup करो**

```powershell
# Ngrok folder में जाओ
cd C:\Users\satyam\AppData\Local\Programs\ngrok

# Ngrok का account बना
# Website: https://dashboard.ngrok.com/signup
# Free tier sign up करो
```

#### **Step 4: Auth token set करो**

Dashboard से अपना auth token copy करो:
```
https://dashboard.ngrok.com/get-started/your-authtoken
```

फिर terminal में:
```powershell
ngrok authtoken YOUR_AUTH_TOKEN_HERE
```

#### **Step 5: Laravel server को port 8000 पर चलाओ**
```powershell
cd c:\Users\satyam\stripe-course
php artisan serve --host=0.0.0.0 --port=8000
```

#### **Step 6: दूसरे terminal में Ngrok tunnel बनाओ**
```powershell
ngrok http 8000
```

**Output:**
```
Session Status: online
Forwarding: https://xxxx-xx-xxx-xxx-xx.ngrok.io -> http://localhost:8000
```

#### **Step 7: Public URL से access करो**

```
https://xxxx-xx-xxx-xxx-xx.ngrok.io
```

**यह URL दुनिया के किसी भी device से काम करेगा!** 🌍

---

## 🔷 OPTION 3: AWS EC2 (Production के लिए)

### **क्या है?**
Amazon का cloud server जहाँ आप अपनी application 24/7 host कर सकते हैं।

### **Steps:**

#### **Step 1: AWS Account बनाओ**
```
Website: https://aws.amazon.com
Free Tier signup करो (1 साल free)
```

#### **Step 2: EC2 Instance launch करो**

1. AWS Dashboard खोलो
2. EC2 → Instances → Launch Instances
3. **AMI चुनो:** Ubuntu 22.04 LTS (Free Tier)
4. **Instance Type:** t2.micro (Free)
5. **Security Group Settings:**
   - Port 80 (HTTP): Allow
   - Port 443 (HTTPS): Allow
   - Port 3306 (MySQL): Allow from your IP
   - Port 22 (SSH): Allow from your IP

#### **Step 3: Key Pair बनाओ और download करो**
```
.pem file को safe place पर save करो
```

#### **Step 4: Instance को public IP दो**
```
Elastic IP allocate करो
```

#### **Step 5: SSH से connect करो**

**Windows (PowerShell):**
```powershell
# .pem file की permissions set करो
icacls "C:\path\to\key.pem" /inheritance:r /grant:r "$env:USERNAME`:`(F`)"

# Server से connect करो
ssh -i "C:\path\to\key.pem" ubuntu@YOUR_PUBLIC_IP
```

#### **Step 6: Server पर Laravel setup करो**

```bash
# Updates install करो
sudo apt update && sudo apt upgrade -y

# PHP और dependencies install करो
sudo apt install -y php php-cli php-fpm php-mysql php-curl \
    php-xml php-mbstring php-zip curl git composer

# Git से project clone करो
cd /var/www
sudo git clone https://github.com/YOUR_REPO_URL stripe-course
cd stripe-course

# Permissions set करो
sudo chown -R www-data:www-data /var/www/stripe-course
sudo chmod -R 755 /var/www/stripe-course
sudo chmod -R 777 /var/www/stripe-course/storage
sudo chmod -R 777 /var/www/stripe-course/bootstrap/cache
```

#### **Step 7: Composer dependencies install करो**
```bash
composer install --no-dev --optimize-autoloader
```

#### **Step 8: .env file बनाओ**
```bash
cp .env.example .env
php artisan key:generate
```

Edit करो: `nano .env`
```
APP_ENV=production
APP_URL=http://YOUR_PUBLIC_IP
STRIPE_KEY=your_key
STRIPE_SECRET=your_secret
DB_CONNECTION=sqlite
```

#### **Step 9: Database migrate करो**
```bash
php artisan migrate --seed
```

#### **Step 10: Nginx setup करो**

```bash
# Nginx install करो
sudo apt install -y nginx

# Configuration file बनाओ
sudo nano /etc/nginx/sites-available/stripe-course
```

Paste करो:
```nginx
server {
    listen 80;
    server_name YOUR_PUBLIC_IP;
    root /var/www/stripe-course/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### **Step 11: Nginx enable करो**
```bash
sudo ln -s /etc/nginx/sites-available/stripe-course /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### **Step 12: PHP-FPM start करो**
```bash
sudo systemctl start php8.1-fpm
sudo systemctl enable php8.1-fpm
```

#### **Done! अब access करो:**
```
http://YOUR_PUBLIC_IP
```

---

## 🔷 OPTION 4: Shared Hosting (सबसे सस्ता)

### **Providers:**
- **Hostinger** (~₹100/month)
- **Bluehost** (~$2.95/month)
- **GoDaddy** (~₹500/year)

### **Steps:**

#### **Step 1: Hosting account लो**
```
cpanel वाली hosting चुनो (WordPress-friendly)
```

#### **Step 2: File Manager में upload करो**

```
1. public_html में सब कुछ upload करो
2. एक folder बनाओ: laravel-app
3. सब files वहाँ upload करो (File Manager से)
```

#### **Step 3: .htaccess file बनाओ**

root में `.htaccess`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### **Step 4: Database create करो**

cPanel → MySQL Databases:
```
- Database name: stripe_course
- User: stripe_user
- Password: strong_password
```

#### **Step 5: .env update करो**
```
DB_HOST=localhost
DB_DATABASE=stripe_course
DB_USERNAME=stripe_user
DB_PASSWORD=strong_password
```

#### **Step 6: SSH से migrate करो (अगर available है)**
```bash
php artisan migrate --seed
```

---

## 🔷 OPTION 5: Heroku (समझने में आसान)

### **Free नहीं है अब पर बहुत सस्ता है**

#### **Step 1: Heroku account बनाओ**
```
https://www.heroku.com
```

#### **Step 2: Procfile बनाओ**

Project root में `Procfile` (no extension):
```
web: vendor/bin/heroku-php-apache2 public/
```

#### **Step 3: Heroku CLI install करो**
```powershell
# Windows
choco install heroku-cli

# या download करो: https://devcenter.heroku.com/articles/heroku-cli
```

#### **Step 4: Login करो**
```powershell
heroku login
```

#### **Step 5: Git repo initialize करो**
```powershell
cd c:\Users\satyam\stripe-course
git init
git add .
git commit -m "Initial commit"
```

#### **Step 6: Heroku app create करो**
```powershell
heroku create stripe-course-app
```

#### **Step 7: Environment variables set करो**
```powershell
heroku config:set APP_KEY=base64:xxxxx
heroku config:set STRIPE_KEY=pk_test_xxx
heroku config:set STRIPE_SECRET=sk_test_xxx
```

#### **Step 8: Deploy करो**
```powershell
git push heroku main
```

#### **Done! App live है:**
```
https://stripe-course-app.herokuapp.com
```

---

## 🎯 मेरे लिए Best Option कौन सा है?

### **अगर सिर्फ खुद test करना है:**
✅ **Local Server (Option 1)** - सबसे आसान, फ्री

### **अगर दोस्तों को दिखाना है:**
✅ **Ngrok (Option 2)** - 2 minute में ready, फ्री URL

### **अगर production पर डालना है:**
✅ **AWS (Option 3)** - सबसे reliable, थोड़ा complex

### **अगर simple hosting चाहिए:**
✅ **Shared Hosting (Option 4)** - बहुत सस्ता

### **अगर mobile-friendly deployment चाहिए:**
✅ **Heroku (Option 5)** - easy to deploy

---

## 🚨 Important: Environment Variables (.env)

### **Production से पहले ये change करो:**

```env
# Current (DEVELOPMENT)
APP_ENV=local
APP_DEBUG=true

# Change करो (PRODUCTION)
APP_ENV=production
APP_DEBUG=false

# Production app key generate करो
php artisan key:generate
```

---

## 🔒 HTTPS/SSL Certificate

### **Ngrok:**
✅ Automatically HTTPS provide करता है

### **AWS:**
```bash
# Let's Encrypt से फ्री SSL लो
sudo apt install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d yourdomain.com
```

### **Shared Hosting:**
✅ cPanel से एक click में SSL enable करो

### **Heroku:**
✅ Automatically HTTPS provide करता है

---

## 📊 Comparison Table

| Feature | Local | Ngrok | AWS | Shared | Heroku |
|---------|-------|-------|-----|--------|--------|
| Cost | FREE | FREE | $5-10 | ₹100+ | $7+ |
| Speed | ⚡⚡⚡ | ⚡⚡ | ⚡⚡⚡ | ⚡ | ⚡⚡ |
| Setup | 5 min | 2 min | 30 min | 10 min | 10 min |
| Uptime | Only when PC on | Only when PC on | 99.9% | 99% | 99% |
| Custom Domain | ❌ | ❌ | ✅ | ✅ | ✅ |
| Scalability | ❌ | ❌ | ✅ | Limited | ✅ |
| SSL | ❌ | ✅ | ✅ | ✅ | ✅ |

---

## 🎓 Recommended Path:

1. **शुरुआत में:** Local Server (Option 1) से development करो
2. **Testing के लिए:** Ngrok (Option 2) से दोस्तों को दिखाओ
3. **Production:** AWS (Option 3) या Shared Hosting (Option 4)

---

## 🛠️ Troubleshooting

### **Port 8000 already in use है?**
```powershell
# दूसरा port use करो
php artisan serve --port=8001
```

### **Connection timeout हो रहा है Ngrok से?**
```powershell
# .env में URL update करो
APP_URL=https://xxxx-xx-xxx-xxx-xx.ngrok.io

# फिर clear cache करो
php artisan config:clear
php artisan cache:clear
```

### **Database error आ रहा है AWS पर?**
```bash
# SSH से check करो
php artisan tinker
# फिर: DB::connection()->getPdo();
```

### **Stripe payment काम नहीं कर रहा है?**
```
1. .env में STRIPE_KEY और STRIPE_SECRET सही हैं?
2. Stripe dashboard में webhook URL set है?
3. HTTPS use कर रहे हो (local exception के साथ)?
```

---

## 📝 Step-by-Step Checklist (Local Server के लिए)

- [ ] Terminal खोला
- [ ] Project folder में गए
- [ ] `composer install` किया
- [ ] `php artisan migrate --seed` किया
- [ ] `php artisan serve --host=0.0.0.0 --port=8000` किया
- [ ] Browser में `http://localhost:8000` खोला
- [ ] Login page दिखा (admin@stripe.com / admin123)
- [ ] Dashboard access किया
- [ ] Test payment किया (4242 4242 4242 4242)
- [ ] Order created दिखा ✅

---

## 🌍 अपने Domain से connect करने का तरीका

### **AWS पर अपना domain लगाओ:**

1. **Domain buy करो** - Godaddy/NameCheap से (~₹200/year)
2. **Elastic IP दो** - AWS console से
3. **DNS records update करो:**
   - A Record: yourdomain.com → YOUR_ELASTIC_IP
   - CNAME: www.yourdomain.com → yourdomain.com
4. **SSL add करो** - Let's Encrypt से (free)
5. **Done!** अब https://yourdomain.com से access कर सकते हो

---

## 🎯 Final Recommendation

**आपके लिए सबसे अच्छा option:**

### **STEP 1: Development करो (Local)**
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```
Access: `http://192.168.0.5:8000` (अपना IP)

### **STEP 2: Testing के लिए (Ngrok)**
```powershell
ngrok http 8000
```
Access: `https://xxxx-xx.ngrok.io` (worldwide)

### **STEP 3: Production (AWS EC2)**
```
ubuntu server setup करो
Nginx + PHP-FPM + SQLite/MySQL
Domain + SSL add करो
```

---

**अब आपका project दुनिया के लिए ready है!** 🚀🌍
