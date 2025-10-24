LARAVEL TEAM SETUP GUIDE (AFTER PULLING FROM GITHUB)
---------------------------------------------------

🧩 INSTALLATIONS (One-time setup)
--------------------------------
Make sure you have installed:
- Laravel Herd (handles PHP, MySQL, and Valet automatically)
- Node.js + npm
- Git
- MySQL Workbench (optional, for DB management)
- Composer (already included in Herd, but confirm)

Cloning
----------------------------
- Make sure to clone the repository inside the Herd folder C:\Users\[name ng user]\Herd\

📂 PROJECT SETUP (After cloning the repo)
----------------------------------------
1. Go inside the project folder:
   cd your-project-folder

2. Install PHP dependencies:
   composer install

3. Install Node dependencies:
   npm install

4. Create .env file:
   cp .env.example .env

5. Generate Laravel app key:
   php artisan key:generate

6. Setup database:
   - Create a new database (via Herd, XAMPP, or Workbench)
   - Update your .env file accordingly:
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3307   # or 3306 depending on your setup
       DB_DATABASE=your_db_name
       DB_USERNAME=root
       DB_PASSWORD=

7. Run migrations and seeders:
   php artisan migrate --seed

8. Build frontend assets:
   npm run dev

9. Add project to Herd:
   - Open Herd
   - Click “Add Site” → select the cloned folder
   - Access the site via the Herd URL (e.g., https://your-project.test)

⚙️ OPTIONAL (for better teamwork)
---------------------------------
- Do not push your real .env file to GitHub.
- Add these to .gitignore:
    /vendor
    /node_modules
    .env
    /storage/framework/cache/data
- Ensure everyone uses the same DB port (3306 or 3307).

