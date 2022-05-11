<?php
include 'functions.php';
// Koneksi ke MySQL database
$pdo = pdo_connect_mysql();

// Get Halaman via GET REQUEST, Default 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Banyaknnya record per page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM barang ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch record,
$barangs = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get total banyak barang di database
$num_barangs = $pdo->query('SELECT COUNT(*) FROM barang')->fetchColumn();
?>


<?=template_header('AddStock | Read')?>

<div class="content read">
	<h2>Stok Barang di Toko Anda</h2>
	<a href="create.php" class="tambah">Tambah Barang</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nama Produk</td>
                <td>Jenis Produk</td>
                <td>Jumlah Stok</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barangs as $barang): ?>
            <tr>
                <td><?=$barang['id']?></td>
                <td><?=$barang['nama_produk']?></td>
                <td><?=$barang['jenis_produk']?></td>
                <td><?=$barang['jumlah_stok']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$barang['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$barang['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_barangs): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>