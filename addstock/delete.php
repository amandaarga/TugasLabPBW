<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// check id terdapat pada tabel atau tidak.
if (isset($_GET['id'])) {

    // memilih record untuk dihapus
    $stmt = $pdo->prepare('SELECT * FROM barang WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $barang = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$barang) {
        exit('Produk tidak dapat ditemukan dengan Id');
    }

    // Confirm untuk menghapus record
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {

            // Yes, record dihapus
            $stmt = $pdo->prepare('DELETE FROM barang WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Produk sudah dihapus!';
        } else {

            // No, kembali ke halaman read.php
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('Tidak ada ID yang ditemukan!');
}
?>


<?=template_header('AddStock | Delete')?>

<div class="content delete">
	<h2>Delete Barang #<?=$barang['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Apakah kamu yakin akan menghapus produk <strong><span style="text-transform:uppercase"><?=$barang['nama_produk']?></span></strong>?</p>
    <div class="yesno">
        <a class="yes" href="delete.php?id=<?=$barang['id']?>&confirm=yes">Yes</a>
        <a class="no" href="delete.php?id=<?=$barang['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>