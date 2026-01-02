# 🚀 Database Access - Quick Reference

## तुरंत Data देखने के तरीके:

### 1️⃣ **Browser में जाओ (सबसे आसान)**
```
https://stripe-course-1.onrender.com/database
```
✅ Beautiful dashboard
✅ सभी tables एक जगह
✅ Export buttons
✅ Statistics

---

### 2️⃣ **JSON Download करो**

**सभी Courses:**
```
https://stripe-course-1.onrender.com/api/export/courses
```

**सभी Orders:**
```
https://stripe-course-1.onrender.com/api/export/orders
```

**सभी Payments:**
```
https://stripe-course-1.onrender.com/api/export/payments
```

**सभी Users:**
```
https://stripe-course-1.onrender.com/api/export/users
```

**Everything (एक file में):**
```
https://stripe-course-1.onrender.com/api/export/all
```

---

### 3️⃣ **CSV Download करो**

**Courses CSV:**
```
https://stripe-course-1.onrender.com/api/export/courses-csv
```

**Orders CSV:**
```
https://stripe-course-1.onrender.com/api/export/orders-csv
```

---

### 4️⃣ **Shell से Direct Access (Render)**

**Render Dashboard खोलो:**
1. https://dashboard.render.com
2. अपना **stripe-course** service select करो
3. **Shell** tab click करो

**फिर ये commands चलाओ:**

```bash
# SQLite में enter करो
sqlite3 database/database.sqlite

# Formatted view
.mode column
.headers on

# सभी courses देखो
SELECT id, title, price FROM courses;

# सभी orders
SELECT o.id, u.name, c.title, o.amount FROM orders o 
JOIN users u ON u.id = o.user_id 
JOIN courses c ON c.id = o.course_id;

# Revenue total
SELECT SUM(amount) as total FROM orders;

# Exit
.quit
```

---

## 📊 Data Structure

### Courses Table
```json
{
  "id": 1,
  "title": "Web Development",
  "price": 999,
  "description": "Learn web dev",
  "created_at": "2025-12-30T18:36:28Z"
}
```

### Orders Table
```json
{
  "id": 1,
  "user_id": 1,
  "course_id": 1,
  "amount": 999,
  "status": "completed",
  "created_at": "2025-12-30T18:36:28Z"
}
```

### Payments Table
```json
{
  "id": 1,
  "order_id": 1,
  "amount": 999,
  "payment_method": "card",
  "transaction_id": "ch_1234567890",
  "status": "completed",
  "created_at": "2025-12-30T18:36:28Z"
}
```

### Users Table
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "created_at": "2025-12-30T18:36:28Z"
}
```

---

## 🎯 Use Cases

| Need | Link |
|------|------|
| Dashboard देखना | `/database` |
| JSON import करना | `/api/export/all` |
| Courses data | `/api/export/courses` |
| Orders report | `/api/export/orders` |
| Payment tracking | `/api/export/payments` |
| Excel में open करना | `/api/export/*-csv` |

---

## 💾 Files Location

**Render Server पर:**
```
/var/www/html/database/database.sqlite
```

**Local (development):**
```
c:\Users\satyam\stripe-course\database\database.sqlite
```

---

## 🔧 यह क्या करता है?

### ExportController.php
- सभी data को JSON/CSV में convert करता है
- Database की stats बताता है
- Pagination support करता है

### Routes Added
```
GET /database                  → Beautiful dashboard
GET /api/export/courses       → Courses JSON
GET /api/export/orders        → Orders JSON  
GET /api/export/payments      → Payments JSON
GET /api/export/users         → Users JSON
GET /api/export/all           → सब कुछ एक साथ
GET /api/export/courses-csv   → Courses CSV
GET /api/export/orders-csv    → Orders CSV
```

### Views Created
```
resources/views/admin/database-viewer.blade.php
↓
Beautiful dashboard with:
- Statistics cards
- All 4 tables
- Export buttons
- Pagination
- Real-time data
```

---

## ✅ अगर Data नहीं दिखे

```bash
# Render Shell में
php artisan migrate:fresh --seed
```

---

## 📱 Mobile/Tablet Support

- Dashboard fully responsive है
- Mobile पर भी सब कुछ work करता है
- Export buttons mobile से भी काम करते हैं

---

## 🔐 Security Note

- Dashboard public accessible है (`/database`)
- अगर private चाहिए तो middleware add करो
- Production में authentication add करने की सलाह है

---

## 📝 Next Steps

1. ✅ Deploy करो: `git push` 
2. ✅ Check करो: `https://stripe-course-1.onrender.com/database`
3. ✅ Export करो: JSON/CSV format
4. ✅ Share करो: किसी को भी data दिखा सकते हो

