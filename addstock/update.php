<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// check id terdapat pada tabel atau tidak.
if (isset($_GET['id'])) {
    if (!empty($_POST)) {

        // Sama seperti create.php
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama_produk = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : '';
        $jenis_produk = isset($_POST['jenis_produk']) ? $_POST['jenis_produk'] : '';
        $jumlah_stok = isset($_POST['jumlah_stok']) ? $_POST['jumlah_stok'] : '';
        
        // Update record
        $stmt = $pdo->prepare('UPDATE barang SET id = ?, nama_produk = ?, jenis_produk = ?, jumlah_stok = ? WHERE id = ?');
        $stmt->execute([$id, $nama_produk, $jenis_produk, $jumlah_stok, $_GET['id']]);
        $msg = 'Data sudah diperbarui!';
    }

    // Get barang dari tabel barang
    $stmt = $pdo->prepare('SELECT * FROM barang WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $barang = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$barang) {
        exit('Produk tidak ditemukan dengan ID tersebut!');
    }
} else {
    exit('Tidak ada ID yang ditemukan!');
}
?>



<?=template_header('AddStock | Update')?>

<!-- <?=$contact['id']?> -->

<div class="content update">
    <h2>Tambah Produk</h2>
    <form action="update.php?id=<?=$barang['id']?>" method="post">

        <!-- input id produk-->
        <label for="id">ID</label>
        <input type="text" name="id" value="<?=$barang['id']?>" id="id">

        <!-- input nama produk -->
        <label for="nama_produk">Nama Produk</label>
        <input type="text" name="nama_produk" value="<?=$barang['nama_produk']?>" id="nama_produk" required>

        <!-- input jenis produk -->
        <label for="jenis_produk">Jenis Produk</label>
        <input type="text" name="jenis_produk" value="<?=$barang['jenis_produk']?>" id="jenis_produk" required>

        <!-- input jumlah stok -->
        <label for="jumlah_stok">Jumlah Stok</label>
        <input type="number" name="jumlah_stok" value="<?=$barang['jumlah_stok']?>" id="jumlah_stok" min="0" required>

        <!-- Tombol tambah -->
        <input type="submit" value="Update">

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>