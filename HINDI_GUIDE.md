# मेनू मैनेजमेंट सिस्टम - हिंदी गाइड

## ✅ पहले ये करें (Database Update)

### Step 1: Database Update करें
Terminal खोलें और ये command चलाएं:

```bash
cd /opt/lampp/htdocs/ayurveda-clinic-main\(2\)/ayurveda-clinic-main
/opt/lampp/bin/mysql -u root ayurveda_clinic < update_db.sql
```

**या फिर phpMyAdmin से:**
1. phpMyAdmin खोलें (http://localhost/phpmyadmin)
2. `ayurveda_clinic` database select करें
3. "Import" tab पर जाएं
4. `update_db.sql` file choose करें
5. "Go" button दबाएं

### Step 2: Permissions Set करें
```bash
chmod -R 777 images/uploads
```

## 🎯 कैसे इस्तेमाल करें

### नया Menu बनाना (जिससे PHP File भी बन जाए)

1. **Admin Panel** में जाएं → **Manage Menus**

2. **Form भरें:**
   - **Menu Name**: जो नाम दिखाना है (जैसे: "हमारी सेवाएं")
   - **URL/File Name**: File का नाम (जैसे: "hamaari-sevayen.php")
   - **Parent Menu**: अगर submenu बनाना है तो select करें
   - **Sort Order**: कौनसे नंबर पर दिखाना है
   - **Meta Title**: Google के लिए title
   - **Meta Description**: Google के लिए description
   - **Custom Page Checkbox**: ✅ इसे checked रखें (PHP file बनाने के लिए)

3. **"Add Menu & Create Page"** button दबाएं

### अब क्या होगा?
- ✅ Database में menu entry बन जाएगी
- ✅ Root folder में PHP file बन जाएगी
- ✅ Content save करने के लिए database entry बन जाएगी

### Content कैसे Add करें

1. Menu के सामने **Edit (✏️)** button पर click करें

2. **Rich Text Editor** में content लिखें:
   - Text type करें
   - Bold, Italic, Colors use करें
   - Images add करें (image icon पर click करके)
   - Tables, Lists बनाएं

3. **"Update Menu & Page"** button दबाएं

### Images कैसे Add करें

**तरीका 1: Upload**
1. Editor में image icon (🖼️) पर click करें
2. अपने computer से image select करें
3. Automatically upload हो जाएगी

**तरीका 2: Drag & Drop**
1. Image को सीधा editor में drag करें
2. Automatically upload हो जाएगी

## 🎨 Editor में क्या-क्या है?

- **Bold/Italic**: Text को bold या italic बनाएं
- **Headings**: बड़े-छोटे headings
- **Colors**: Text और background color
- **Lists**: Bullets और numbers
- **Images**: Photos add करें
- **Links**: Website links add करें
- **Tables**: Tables बनाएं
- **Undo/Redo**: गलती हो तो वापस करें

## ⚠️ Important Tips

1. **Image Size**: बड़ी images को पहले compress कर लें
2. **File Names**: Spaces की जगह hyphen (-) use करें
3. **SEO**: Meta Title और Description जरूर भरें
4. **Backup**: सारा content database में save होता है

## 🔧 अगर Problem आए

### Images upload नहीं हो रहीं?
```bash
chmod -R 777 images/uploads
```

### Database error आ रहा है?
- Check करें कि `update_db.sql` run हुआ है या नहीं
- phpMyAdmin में जाकर tables check करें

### PHP file नहीं बन रही?
- "Custom Page" checkbox ✅ checked है या नहीं check करें
- Root folder में write permission है या नहीं check करें

## 📞 मदद चाहिए?

Error logs यहाँ check करें:
```bash
tail -f /opt/lampp/logs/error_log
```

---

**सवाल है तो पूछ लीजिए! आपका system तैयार है! 🚀**
