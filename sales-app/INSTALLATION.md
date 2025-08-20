# Panduan Instalasi - Sales App Laravel

## Langkah-langkah Instalasi

### 1. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database & Seed Data
```bash
php artisan migrate --seed
```

### 4. Jalankan Aplikasi
```bash
php artisan serve
```

## Akses Login Default

- **Admin**: admin@example.com / password
- **Kasir**: kasir@example.com / password  
- **Pelanggan**: pelanggan@example.com / password

## URL Aplikasi
http://localhost:8000

## Struktur Database yang Dibuat

### Tabel Users
- id (bigIncrements)
- name (string, 100)
- email (string, unique)
- password (string)
- role (enum: 'admin','kasir','pelanggan')
- timestamps

### Tabel Products
- id (bigIncrements)
- code (string, 50, unique)
- name (string, 150)
- category (string, 100)
- stock (integer, default 0)
- purchase_price (decimal(12,2))
- selling_price (decimal(12,2))
- timestamps

### Tabel Transactions
- id (bigIncrements)
- user_id (foreign key → users.id, onDelete cascade)
- type (enum: 'penjualan','pembelian')
- total (decimal(12,2))
- timestamps

### Tabel TransactionDetails
- id (bigIncrements)
- transaction_id (foreign key → transactions.id, onDelete cascade)
- product_id (foreign key → products.id, onDelete cascade)
- quantity (integer)
- price (decimal(12,2))
- subtotal (decimal(12,2))
- timestamps

## Data Sample yang Di-seed

### Users:
1. Admin - admin@example.com
2. Kasir 1 - kasir@example.com
3. Pelanggan Test - pelanggan@example.com

### Products (5 produk):
1. PRD001 - Laptop Acer Aspire 5 (Elektronik) - Stock: 15
2. PRD002 - Mouse Wireless Logitech (Aksesoris) - Stock: 50
3. PRD003 - Keyboard Mechanical RGB (Aksesoris) - Stock: 25
4. PRD004 - Monitor LED 24 inch (Elektronik) - Stock: 10
5. PRD005 - Headset Gaming HyperX (Gaming) - Stock: 30