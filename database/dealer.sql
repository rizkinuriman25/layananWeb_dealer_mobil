CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE mobil (
    id_mobil INT AUTO_INCREMENT PRIMARY KEY,
    merk VARCHAR(50),
    model VARCHAR(50),
    tahun INT,
    harga DECIMAL(15,2),
    stok INT DEFAULT 0,
    status ENUM('tersedia', 'terjual', 'indent') DEFAULT 'tersedia',
    gambar VARCHAR(255)
);

CREATE TABLE penjualan (
    id_penjualan INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT,
    id_mobil INT,
    jumlah INT,
    total_harga DECIMAL(15,2),
    metode_pembayaran ENUM('Cash', 'Kredit', 'Transfer'),
    status_pembayaran ENUM('Lunas', 'Belum Lunas'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan),
    FOREIGN KEY (id_mobil) REFERENCES mobil(id_mobil)
);
