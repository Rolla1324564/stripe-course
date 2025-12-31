# 🚀 NGROK पर अपना Project Host करने का Step-by-Step Guide

---

## ✅ Total Time: 10 MINUTES | Total Cost: ₹0

---

## 📋 Requirements

- ✅ अपका project (stripe-course) ready है
- ✅ PHP installed है
- ✅ Composer installed है
- ✅ Internet connection

---

## 🎯 STEP 1: Ngrok Download करो (2 MINUTES)

### **Step 1a: Website पर जाओ**
```
https://ngrok.com/download
```

### **Step 1b: Windows version download करो**
```
Click: "ngrok for Windows"
Download होगी: ngrok-v3-stable-windows-amd64.zip (लगभग 30MB)
```

### **Step 1c: Extract करो**

**Option 1: Windows Explorer से**
```
1. Downloads folder में जाओ
2. ngrok-v3-stable-windows-amd64.zip पर right-click करो
3. "Extract All" click करो
4. C:\Users\satyam\ में extract करो

Result: C:\Users\satyam\ngrok\ngrok.exe
```

**Option 2: PowerShell से**
```powershell
cd $env:USERPROFILE\Downloads
Expand-Archive -Path ngrok-v3-stable-windows-amd64.zip -DestinationPath C:\Users\satyam\ngrok
```

---

## 🔑 STEP 2: Ngrok Account बनाओ & Auth Token लो (2 MINUTES)

### **Step 2a: Ngrok पर account बनाओ**
```
Website: https://ngrok.com/signup
Google/GitHub से sign up करो (fastest)
```

### **Step 2b: Email verify करो**
```
ngrok आपको email भेजेगा
उसमें "Verify email" पर click करो
```

### **Step 2c: Auth Token लो**
```
Website: https://dashboard.ngrok.com/get-started/your-authtoken
```

**Output दिखेगा:**
```
Your Authtoken
ngrok config add-authtoken 2xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**इस पूरे command को copy करो!**

---

## ⚙️ STEP 3: Ngrok Configure करो (1 MINUTE)

### **PowerShell खोलो**
```powershell
# Windows key दबाओ और type करो: PowerShell
# Click करो: Windows PowerShell
```

### **Command paste करो**
```powershell
# आपके dashboard से copy किया हुआ command
# Example:
ngrok config add-authtoken 2xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

**Output:**
```
Authtoken saved to configuration file: C:\Users\satyam\AppData\Local\ngrok\ngrok.yml
```

✅ **Done!** Ngrok configured है।

---

## 🚀 STEP 4: Laravel Server Run करो (IMPORTANT!)

### **पहला Terminal खोलो**

```powershell
# Project folder में जाओ
cd c:\Users\satyam\stripe-course

# Check करो database है
# File: c:\Users\satyam\stripe-course\database\database.sqlite

# अगर database नहीं है तो create करो:
php artisan migrate --seed

# Server chalaao
php artisan serve --port=8000
```

**Output:**
```
   Laravel development server started: http://127.0.0.1:8000
```

✅ **Server चल गया port 8000 पर**

---

## 🌐 STEP 5: Ngrok Tunnel Create करो (STAR!)

### **दूसरा Terminal खोलो**

```powershell
# Ngrok folder में जाओ
cd C:\Users\satyam\ngrok

# Tunnel बनाओ
./ngrok http 8000
```

**या अगर error आए तो:**
```powershell
ngrok http 8000
```

---

## 🎉 STEP 6: Public URL मिलेगा

### **Terminal में यह देखो:**

```
ngrok                                                    (Ctrl+C to quit)

Forwarding                    https://1234-56-789-10.ngrok.io -> http://localhost:8000
Forwarding                    http://1234-56-789-10.ngrok.io -> http://localhost:8000

Web Interface                 http://127.0.0.1:4040
```

---

## ✨ अब तुम्हारा App Online है!

### **3 तरीकों से access कर सकते हो:**

#### **1. अपने Computer से (Local)**
```
http://localhost:8000
```

#### **2. Same Network से (बाकी devices)**
```
http://192.168.0.5:8000
(अपना IP use करो)
```

#### **3. Internet से (दुनिया के कहीं से भी)** ⭐
```
https://1234-56-789-10.ngrok.io

Example:
https://1234-56-789-10.ngrok.io/admin/login
```

---

## 🎬 LIVE TEST करो

### **Browser में खोलो:**
```
https://1234-56-789-10.ngrok.io
```

### **देखो क्या आता है:**
```
✅ Courses listing page
✅ या welcome page
✅ Admin login page भी access हो सकता है
```

### **Admin Login करो:**
```
Email: admin@stripe.com
Password: admin123
```

### **Admin Dashboard खोलो:**
```
https://1234-56-789-10.ngrok.io/admin/dashboard
```

---

## 💡 Ngrok Dashboard (monitoring)

### **देखो कौन access कर रहा है:**
```
Open in browser: http://127.0.0.1:4040
```

**दिखेगा:**
```
✅ सभी requests (GET, POST, etc.)
✅ Response codes (200, 404, etc.)
✅ Headers और Body
✅ Replay requests
```

---

## 📱 Ngrok URL Share करना

### **अपने दोस्तों को दो:**
```
https://1234-56-789-10.ngrok.io

"Ek click करो aur mera project dekho!"
```

### **Testing करें:**
```
Courses dekh sakte ho
Payment form dekh sakte ho
Admin login dekh sakte ho
```

---

## ⚠️ Important Notes

### **1. हर restart पर URL बदल जाता है**
```
पहली बार:  https://1234-56-789-10.ngrok.io
दूसरी बार:  https://9876-54-321-09.ngrok.io (अलग!)
```

**Solution:**
```
- Paid plan लो ($5/month) → fixed URL
- या हर बार नया URL दोस्तों को दो
```

### **2. 2 Hours का timeout है (Free)**
```
2 hours बाद connection disconnect हो जाता है

Solution:
- Session फिर से start करो
- या Paid plan लो
```

### **3. Rate limiting (Free)**
```
120 requests/minute limit है

Solution:
- Paid plan: unlimited
- Test करो धीरे-धीरे
```

---

## 🛠️ Troubleshooting

### **Problem 1: "ngrok: The term 'ngrok' is not recognized"**
```
Solution:
जाओ C:\Users\satyam\ngrok में
फिर ./ngrok http 8000 करो
```

### **Problem 2: "Connection refused"**
```
✅ क्या Laravel server चल रहा है?
   Check करो: http://localhost:8000
   
✅ Port 8000 में काम कर रहा है?
   
✅ दूसरा program port 8000 use कर रहा है?
   php artisan serve --port=8001 से 8001 use करो
```

### **Problem 3: "Ngrok dashboard error"**
```
Solution:
- Ngrok terminal को restart करो (Ctrl+C फिर फिर से run)
- Browser cache clear करो
```

### **Problem 4: SSL Certificate warning**
```
✅ Normal है - ngrok free tunnel के लिए
✅ Production में proper SSL लगाना पड़ेगा
```

---

## 📊 Complete Setup Checklist

```
☐ Ngrok download किया
☐ Extract किया (C:\Users\satyam\ngrok\)
☐ Account बनाया (ngrok.com)
☐ Auth token लिया
☐ Config किया (ngrok config add-authtoken)
☐ Laravel server run किया (php artisan serve --port=8000)
☐ Ngrok tunnel बनाया (ngrok http 8000)
☐ Public URL मिला
☐ Browser में test किया
☐ Admin login किया (admin@stripe.com / admin123)
```

---

## 🎯 REAL EXAMPLE

### **तुम्हारे case में:**

#### **Terminal 1: Laravel Server**
```powershell
C:\Users\satyam\stripe-course> php artisan serve --port=8000
Laravel development server started: http://127.0.0.1:8000
```

#### **Terminal 2: Ngrok**
```powershell
C:\Users\satyam\ngrok> ngrok http 8000

Forwarding                    https://abc-123-def-456.ngrok.io -> http://localhost:8000
```

#### **Browser में खोलो:**
```
https://abc-123-def-456.ngrok.io
↓
Login page दिखेगा या courses दिखेंगे
```

#### **Admin area:**
```
https://abc-123-def-456.ngrok.io/admin/login
↓
Email: admin@stripe.com
Password: admin123
↓
Dashboard खुलेगा ✅
```

---

## 🚀 NEXT STEPS

### **अगर 2 hours से ज्यादा चाहिए:**
```
→ Railway.app use करो (permanent free)
```

### **अगर fixed URL चाहिए:**
```
→ Ngrok Paid ($5/month) या Railway.app (free)
```

### **अगर production deploy चाहिए:**
```
→ Railway, Render, या Oracle Cloud
```

---

## 📞 Help Commands

```powershell
# Version check करो
ngrok version

# Help देखो
ngrok help

# Specific port के लिए
ngrok http 8000

# HTTPS disable करना (अगर problem हो)
ngrok http --scheme=http 8000

# Custom subdomain (paid)
ngrok http 8000 --subdomain=myapp
```

---

## 🎓 Learning Points

```
✅ Localhost से public internet तक पहुंचना
✅ Tunneling का concept
✅ URL forwarding कैसे काम करता है
✅ HTTPS/SSL certificates
✅ Network debugging (ngrok dashboard)
```

---

## 📝 Video देखना हो तो:

```
YouTube search: "Ngrok tutorial for beginners"
या
"How to expose localhost using ngrok"
```

---

## 🎉 तुम तैयार हो!

अब तुम्हारा project internet पर है!

```
✨ Share करो: https://abc-123-def-456.ngrok.io
🎓 सिखाओ: कैसे काम करता है
🚀 Deploy करो: Railway पर (long-term के लिए)
```

---

**अब शुरू कर दो! कोई भी problem हो तो पूछना!** 🔧✨
