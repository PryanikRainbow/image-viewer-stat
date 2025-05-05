# README

## 📸 Interface Screenshots

### 1. banner.php
   ![banner.php](screenshots/banner.png)

### 2. admin/login.php
   ![admin/login.php](screenshots/admin_login.png)

### 3. admin/dashboard.php
   ![admin/dashboard.php](screenshots/admin_dashboard.png)


## 🗄️ Database Architecture

### 📊 Table: `banner_stats`

| Field      | Type         | NULL | Key | Default           | Extra             |
|------------|--------------|------|-----|-------------------|-------------------|
| id         | int          | NO   | PRI | NULL              | auto_increment    |
| ip_address | varchar(45)  | NO   | UNI | NULL              |                   |
| hit_count  | int          | NO   |     | 1                 |                   |

---

### 📊 Table: `users`

| Field      | Type          | NULL | Key | Default           | Extra             |
|------------|---------------|------|-----|-------------------|-------------------|
| id         | int           | NO   | PRI | NULL              | auto_increment    |
| login      | varchar(255)  | NO   | UNI | NULL              |                   |
| password   | varchar(255)  | NO   |     | NULL              |                   |
| created_at | timestamp     | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |

---

