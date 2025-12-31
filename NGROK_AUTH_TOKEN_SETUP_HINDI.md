# 🔑 Ngrok Auth Token Set करने का Complete Guide

---

## 📋 Total Time: 3 MINUTES

---

## STEP 1: Ngrok Dashboard पर जाओ

### Browser खोलो और ये URL खोलो:
```
https://dashboard.ngrok.com/get-started/your-authtoken
```

**या:**

```
1. https://ngrok.com/ पर जाओ
2. Login करो (email/password जो signup में दिया था)
3. "Your Auth Token" section खोलो
```

---

## STEP 2: Auth Token Copy करो

### Dashboard में तुम्हें ये दिखेगा:

```
┌─────────────────────────────────────────┐
│  Your Authtoken                         │
├─────────────────────────────────────────┤
│                                         │
│  ngrok config add-authtoken \           │
│  2abc123def456ghi789jkl012mno345pqr    │
│                                         │
│  [Copy Button]                          │
└─────────────────────────────────────────┘
```

### Copy करो:
```
पूरा command copy करो (या सिर्फ token)

Token अकेला:
C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>GSXRYC6Q6FSDOMVOVEYINXRBVXUBPXRO
'GSXRYC6Q6FSDOMVOVEYINXRBVXUBPXRO' is not recognized as an internal or external command,
operable program or batch file.

C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>


```

---

## STEP 3: PowerShell में Paste करो

### अभी तुम यहाँ हो:
```
C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>
```

### Option A: पूरा Command Paste करो (सबसे आसान)

Dashboard से copy किया हुआ पूरा command:
```powershell
ngrok config add-authtoken 2abc123def456ghi789jkl012mno345pqr
```

**Paste करो और Enter दबाओ**

---

### Option B: Manual तरीका

```powershell
.\ngrok.exe config add-authtoken 2abc123def456ghi789jkl012mno345pqr
```

**Replace करो:**
- `2abc123def456ghi789jkl012mno345pqr` → तुम्हारा actual token

---

## ✅ अगर Successful हो:

```
Authtoken saved to configuration file: 
C:\Users\satyam\AppData\Local\ngrok\ngrok.yml

C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>
```

✅ **Done! Token set हो गया!**

---

## ❌ अगर Error आए:

### Error 1: "ngrok is not recognized"
```
Solution:
- सुनिश्चित करो कि तुम सही folder में हो
- cd C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64
```

### Error 2: "Invalid token"
```
Solution:
- Token सही है या नहीं check करो
- Dashboard से फिर से copy करो
- कोई space या extra character तो नहीं?
```

### Error 3: "Permission denied"
```
Solution:
- PowerShell को Admin के साथ खोलो
- Windows Key → PowerShell → Right-click → Run as Administrator
```

---

## STEP 4: अब Ngrok Server Run करो

**Same Terminal में:**

```powershell
.\ngrok.exe http 8000
```

---

## 🎉 Output:

```
ngrok                                       (Ctrl+C to quit)

Session Status                online
Session Expires               1 hour, 59 minutes
Version                       3.0.0
Region                        us (United States)
Latency                       45ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://1234-5678-abcd.ngrok.io -> http://localhost:8000
Forwarding                    http://1234-5678-abcd.ngrok.io -> http://localhost:8000

Connections                   ttl     opn     rt1     rt5     p50     p95
                              0       0       0.00    0.00    0.00    0.00
```

✅ **अब तुम्हारा app LIVE है!**

---

## 🌐 अब Browser में खोलो:

### Admin Dashboard:
```
https://1234-5678-abcd.ngrok.io/admin/login

Email: admin@stripe.com
Password: admin123
```

**Replace करो:** `1234-5678-abcd` → तुम्हारा actual URL

---

## 📋 COMPLETE STEP-BY-STEP:

```
1️⃣ Browser खोलो
   https://dashboard.ngrok.com/get-started/your-authtoken

2️⃣ Token Copy करो
   (पूरा command या सिर्फ token)

3️⃣ PowerShell में Paste करो
   .\ngrok.exe config add-authtoken YOUR_TOKEN

4️⃣ Enter दबाओ
   Output: "Authtoken saved..."

5️⃣ Ngrok run करो
   .\ngrok.exe http 8000

6️⃣ Public URL मिलेगा
   https://xxxx-xxxx.ngrok.io

7️⃣ Browser में खोलो
   https://xxxx-xxxx.ngrok.io/admin/login
```

---

## ✨ Visual Example:

### Dashboard से Token Copy:
```
┌─────────────────────────────────┐
│ ngrok config add-authtoken \    │  ← ये सब copy करो
│ 2a1b3c5d7e9f1h3j5k7m9n0p1r  │
└─────────────────────────────────┘
              ↓
     [Copy Button Click करो]
              ↓
```

### PowerShell में Paste:
```
C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>
ngrok config add-authtoken 2a1b3c5d7e9f1h3j5k7m9n0p1r
[Enter दबाओ]

Output:
Authtoken saved to configuration file!
```

### फिर Run करो:
```
C:\Users\satyam\Downloads\ngrok-v3-stable-windows-amd64>
.\ngrok.exe http 8000
[Enter दबाओ]

Output:
Forwarding https://abc-123-def.ngrok.io -> http://localhost:8000
```

---

## 🎯 अब क्या करो?

```
✅ Browser खोलो
✅ https://abc-123-def.ngrok.io खोलो
✅ Admin login करो
✅ Dashboard देखो
✅ URL दोस्तों को भेजो! 📱
```

---

**अब Ready हो गया!** 🚀

Token set करने में कोई problem हो तो बता! 🔧
