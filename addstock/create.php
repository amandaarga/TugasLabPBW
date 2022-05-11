<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if post empty (kosong)
if (!empty($_POST)) {
    // jika post data tidak empty (kosong), insert new record
    // Set Variables
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
    $jenis_produk = isset($_POST['jenis_produk']) ? $_POST['jenis_produk'] : '';
    $jumlah_stok = isset($_POST['jumlah_stok']) ? $_POST['jumlah_stok'] : '';

    // Insert record baru
    $stmt = $pdo->prepare('INSERT INTO barang VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $nama_produk, $jenis_produk, $jumlah_stok]);

    // Output pesan
    $msg = 'Produk Ditambahkan!';
}
?>


<?=template_header('AddStock | Create')?>

<div class="content update">
	<h2>Tambah Produk</h2>
    <form action="create.php" method="post">

        <!-- input id produk-->
        <label for="id">ID</label>
        <input type="text" name="id" value="auto" id="id">

        <!-- input nama produk -->
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="nama_produk" id="nama_produk" required>

        <!-- input jenis produk -->
        <label for="jenis_produk">Jenis Produk</label>
        <input type="text" name="jenis_produk" id="jenis_produk" required>

        <!-- input jumlah stok -->
        <label for="jumlah_stok">Jumlah Stok</label>
        <input type="number" name="jumlah_stok" id="jumlah_stok" min="0" required>

        <!-- Tombol tambah -->
        <input type="submit" value="Tambah">

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>