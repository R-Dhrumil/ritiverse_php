# RiTiVerse — cPanel Live Deployment & Setup Guide

Shivayhost / cPanel par live hosting ke liye step-by-step checklist:

---

## 1. File Manager Location Checklist
- **Path:** Saara code direct `public_html/` root directory me hona chahiye.
- **Check Structure:**
  ```text
  public_html/
  ├── index.php
  ├── services.php
  ├── projects.php
  ├── about.php
  ├── contact.php
  ├── login.php
  ├── database.sql
  ├── .htaccess
  ├── admin/
  ├── api/
  ├── assets/
  ├── css/
  ├── includes/
  │   ├── config.php
  │   ├── db.php
  │   ├── header.php
  │   └── footer.php
  └── js/
  ```
- **Subfolder Issue Fix:** Agar zip file extract karte waqt files kisi subfolder me chali gayi ho (jaise `public_html/ritiverse_php/`), to:
  1. Us folder ke andar jayein.
  2. "Select All" click karein.
  3. "Move" button press karke destination path `/public_html` daalein.

---

## 2. Default `index.html` Deletion Checklist
- Hosting providers (jaise Shivayhost/cPanel) account create hote hi ek dummy `index.html` ya `default.html` daal dete hain.
- Apache web server `index.html` ko pehle load karta hai.
- **Action:** File Manager me jaakar agar koi default `index.html` ya `default.html` dikhe, to use **Delete** kar dein taaki aapka **`index.php`** direct load ho.
- *Note:* Hamaare `.htaccess` me humne `DirectoryIndex index.php index.html` aur auto-redirect rule bhi lagaya hua hai, jo automatic `index.php` ko priority deta hai.

---

## 3. MySQL Database Setup Checklist
1. cPanel me **MySQL Databases** me jaakar new database create karein (e.g. `cpaneluser_ritivers_main`).
2. New database user create karein aur use full privileges assign karein.
3. cPanel **phpMyAdmin** open karein aur us database ko select karein.
4. **Import** tab par click karein aur root me bani hui `database.sql` file upload karke execute karein.
5. `includes/config.php` file open karke ye credentials match karein:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'cpaneluser_ritivers_main');
   define('DB_USER', 'cpaneluser_dbuser');
   define('DB_PASS', 'your_password_here');
   ```

---

## 4. Free SSL (AutoSSL) Activation Checklist
- **Issue:** Jab nameserver update hota hai, browser self-signed SSL ke kaaran "Connection is not private" warning dikha sakta hai.
- **Fix:**
  1. cPanel me **"SSL/TLS Status"** search karein.
  2. `ritiverse.in` aur `www.ritiverse.in` select karein.
  3. **"Run AutoSSL"** button par click karein.
  4. 1-2 minutes me free certificate auto-install ho jayega.

---

## 5. Admin Panel Access
- **URL:** `https://ritiverse.in/admin/` ya `https://ritiverse.in/login.php`
- **Default Username:** `admin` (ya `admin@ritiverse.in`)
- **Default Password:** `Admin@123`
