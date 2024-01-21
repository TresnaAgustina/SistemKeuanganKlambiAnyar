# SISKEU - UD Klambi Anyar
sistem keuangan untuk mengatur keuangan (Pemasukan, pengeluaran, penggajian) pada UD Klambi Anyar

## Installasi
1. **Clone Repo:**
    ```bash
    git clone https://github.com/TresnaAgustina/Siskeu-UdKlambiAnyar.git

2. **Install Depedensi:**
   ```bash
   composer install

3. **Salin file .env:**
   ```bash
   cp .env.example .env

4. **Generate Application Key:**
   ```bash
   php artisan key:generate

5. **Run Migration:**
   ```bash
   php artisan migrate

6. **Run Seeder:**
   ```bash
   php artisan db:seed

7. **Run Server:**
   ```bash
   php artisan serve
