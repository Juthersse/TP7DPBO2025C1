# TP7DPBO2025C1

# Janji
Saya Muhammad Ichsan Khairullah dengan NIM 2306924 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemograman Berorientasi Objek
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah
dispesifikasikan. Aamiin.

# Desain Program
Program ini adalah sistem manajemen restoran berbasis PHP dengan interface GUI sederhana. Sistem ini memungkinkan pengguna untuk mengelola data restoran, termasuk kategori makanan, daftar makanan, pesanan, dan detail pesanan. Berikut adalah desain program:
1. Struktur Folder
   - class/: Berisi kelas PHP untuk mengelola logika bisnis (Category, Dish, Order).
   - config/: Berisi konfigurasi database.
   - database/: Berisi file SQL untuk membuat dan mengisi database.
   - view/: Berisi file tampilan untuk berbagai halaman (dishes, categories, orders, dll.).
   - index.php: File utama untuk routing dan pengelolaan logika aplikasi.
   - style.css: File CSS sederhana untuk desain interface pengguna.
2. Database
   Database bernama restoran_db memiliki 4 tabel utama:
   - categories: Menyimpan kategori makanan.
   - dishes: Menyimpan daftar makanan.
   - orders: Menyimpan data pesanan.
   - order_items: Menyimpan detail item dalam pesanan.
3. Fitur Utama
   1) Manajemen Kategori:
      - Tambah, edit, dan hapus kategori makanan.
   2) Manajemen Makanan:
      - Tambah, edit, hapus, dan cari makanan berdasarkan nama/deskripsi.
   3) Manajemen Pesanan:
      - Tambah, edit, hapus pesanan.
      - Tambah item ke pesanan.
      - Ubah status pesanan (menunggu, sedang disiapkan, sudah disajikan, sudah dibayar).
   4) Detail Pesanan:
      - Lihat detail pesanan, termasuk item dan total harga.
      - Hapus item dari pesanan.
   5) Pencarian:
      - Cari makanan atau pesanan berdasarkan kata kunci.
     
# Penjelasan Alur Program
1. Inisialisasi
   - File index.php memuat kelas Dish, Category, dan Order.
   - Koneksi database diatur melalui kelas Database di db.php.
2. Routing
   - Parameter page di URL menentukan halaman yang akan ditampilkan:
     - ?page=dishes: Menampilkan daftar makanan.
     - ?page=categories: Menampilkan daftar kategori.
     - ?page=orders: Menampilkan daftar pesanan.
     - ?page=order_details&id=<order_id>: Menampilkan detail pesanan.
3. Manajemen Data
   - CRUD Kategori:
     - Tambah kategori: Form di categories.php memanggil metode createCategory di Category.php.
     - Edit kategori: Data kategori diambil dengan getCategoryById, lalu diperbarui
     - dengan updateCategory.
     - Hapus kategori: Memanggil metode deleteCategory.
   - CRUD Makanan:
     - Tambah makanan: Form di dishes.php memanggil metode createDish di Dish.php.
     - Edit makanan: Data makanan diambil dengan getDishById, lalu diperbarui dengan updateDish.
     - Hapus makanan: Memanggil metode deleteDish.
   - CRUD Pesanan:
     - Tambah pesanan: Form di orders.php memanggil metode createOrder di Order.php.
     - Tambah item ke pesanan: Memanggil metode addOrderItem.
     - Edit pesanan: Data pesanan diambil dengan getOrderById, lalu diperbarui dengan updateOrder.
     - Hapus pesanan: Memanggil metode deleteOrder.
4. Pencarian
   - Form pencarian di index.php memanggil metode searchDishes atau searchOrders berdasarkan tipe pencarian.
5. Tampilan
   - Header (view/header.php) dan footer (view/footer.php) digunakan di semua halaman.
   - Tampilan data menggunakan tabel HTML dengan aksi (edit, hapus, dll.) di setiap baris.

# Entity-Relationship Diagram
![Screenshot 2025-04-20 213954](https://github.com/user-attachments/assets/a3a33709-e326-4796-bc2e-1a71387bfde1)
## Penjelasan ERD:
### Entitas dan Atribut:
1. CATEGORIES
   - id (Primary Key): ID unik untuk kategori
   - name: Nama kategori (contoh: Appetizers, Main Course)
   - description: Deskripsi kategori
2. DISHES
   - id (Primary Key): ID unik untuk menu makanan
   - name: Nama menu
   - description: Deskripsi menu
   - price: Harga menu
   - category_id (Foreign Key): Referensi ke tabel CATEGORIES
3. ORDERS
   - id (Primary Key): ID unik untuk pesanan
   - customer_name: Nama pelanggan
   - table_number: Nomor meja
   - status: Status pesanan (pending, preparing, served, paid)
   - order_date: Tanggal dan waktu pesanan
4. ORDER_ITEMS
   - id (Primary Key): ID unik untuk item pesanan
   - order_id (Foreign Key): Referensi ke tabel ORDERS
   - dish_id (Foreign Key): Referensi ke tabel DISHES
   - quantity: Jumlah item yang dipesan
### Relasi:
1. CATEGORIES ke DISHES: Relasi one-to-many
   - Satu kategori dapat memiliki banyak menu makanan
   - Setiap menu makanan hanya termasuk dalam satu kategori
2. ORDERS ke ORDER_ITEMS: Relasi one-to-many
   - Satu pesanan dapat memiliki banyak item pesanan
   - Setiap item pesanan hanya termasuk dalam satu pesanan
3. DISHES ke ORDER_ITEMS: Relasi one-to-many
   - Satu menu makanan dapat muncul di banyak item pesanan
   - Setiap item pesanan merujuk ke satu menu makanan

# Dokumentasi
![2025-04-20 21-45-16](https://github.com/user-attachments/assets/772eb22a-2445-4bce-9794-3058ef27be2f)

