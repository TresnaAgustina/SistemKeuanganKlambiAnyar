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

### Note:
Sebelum memulai proses pengembangann, pastikan sudah berada pada branch `dev` dan membuat branch baru dengan nama sendiri, `ex: agus`
1. **Pindah dari `main` ke-branch `dev`:**
   ```bash
   git checkout dev

2. **Buat branch baru**
   ```bash
   git brach nama_branch
**Note: rubah `nama_branch` sesuai dengan kebutuhan**

3. **Pindah sekaligus membuat branch baru:**
   ```bash
   git checkout -M nama_branch
**Note: rubah `nama_branch` sesuai dengan kebutuhan**
