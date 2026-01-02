# 🔄 AUTO-SYNC SETUP GUIDE

## क्या है यह?
हर 1 मिनट में Render से आपके localhost database को automatically update करेगा।

## दो तरीके:

### ✅ तरीका 1: PowerShell Script (BEST - Windows के लिए) 

**1️⃣ PowerShell को Admin mode में खोलो:**
```
Win + X → Windows PowerShell (Admin)
```

**2️⃣ Execution Policy set करो (एक बार):**
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

**3️⃣ Auto-sync चलाओ:**
```powershell
C:\Users\satyam\stripe-course\auto-sync.ps1
```

✅ अब यह हर 1 मिनट में automatically Render से data pull करेगा
✅ Logs save होंगे: `C:\Users\satyam\stripe-course\logs\sync.log`

---

### ✅ तरीका 2: Windows Task Scheduler (BEST - Persistent)

**1️⃣ Windows Task Scheduler खोलो:**
```
Win + X → Task Scheduler
```

**2️⃣ "Create Task" पर क्लिक करो:**
- Name: `Stripe Course Auto Sync`
- Description: `Auto sync Render data every 1 minute`
- Checkboxes: ✅ Run with highest privileges

**3️⃣ Triggers tab में:**
- Click "New"
- Begin the task: On a schedule
- One time ✓
- Set time to now
- Repeat task every: 1 minute
- Duration: Indefinitely
- ✅ Click OK

**4️⃣ Actions tab में:**
- Click "New"
- Program/script: `powershell.exe`
- Add arguments: `-ExecutionPolicy Bypass -NoProfile -File "C:\Users\satyam\stripe-course\auto-sync.ps1"`
- ✅ Click OK

**5️⃣ "OK" पर क्लिक करके task create करो**

---

### ✅ तरीका 3: Batch Script (Simple)

बस यह .bat file run करो:
```
C:\Users\satyam\stripe-course\auto-sync.bat
```

---

## 🧪 Test करो:

```bash
# एक बार manually चलाओ
php artisan sync:pull

# या schedule list देखो
php artisan schedule:list
```

---

## 📊 Database Status Check:

```bash
# Current sync status
php sync.php status

# Manual push (अगर चाहो)
php sync.php push
```

---

## 🛑 Stop करने के लिए:

**PowerShell में:** `Ctrl + C`

**Task Scheduler में:** Task को disable करो
- Task Scheduler खोलो → Task name पर right-click → Disable

---

## 📝 Logs देखो:

```bash
# PowerShell script logs
cat C:\Users\satyam\stripe-course\logs\sync.log

# या directly
Get-Content C:\Users\satyam\stripe-course\logs\sync.log -Tail 50
```

---

## ✅ यह काम करेगा:
✅ Har 1 minute में Render से data pull करेगा
✅ Localhost database automatically update होगा  
✅ Courses, Users, Orders, Payments सब sync होंगे
✅ Existing data update होगा (replace नहीं)
✅ New data automatically add होगा

---

**RECOMMENDED:** तरीका 2 (Task Scheduler) - यह restart के बाद भी automatically चलेगा!
