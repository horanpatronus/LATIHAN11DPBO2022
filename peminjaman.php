<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Peminjaman.class.php");
include("includes/Member.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$member = new Member($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$peminjaman->open();
$member->open();
$buku->getBuku();
$peminjaman->getPeminjaman();
$member->getMember();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $peminjaman->delete($id);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $id = $_GET['id_edit'];

    $peminjaman->statusPeminjaman($id);
    header("location:peminjaman.php");
}

$data = null;
$data_buku = null;
$data_member = null;
$no = 1;

while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data_member .= "<option value='".$nim."'>".$nama."</option>";
}

while (list($id_buku, $judul_buku, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    $data_buku .= "<option value='".$id_buku."'>".$judul_buku."</option>";
}

while (list($id, $nim, $id_buku, $status) = $peminjaman->getResult()) {
    $member->getMemberByNIM($nim);
    $buku->getBukuById($id_buku);
    if ($status == "Sudah Dikembalikan") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $member->getResult()['nama'] . "</td>
            <td>" . $buku->getResult()['judul_buku'] . "</td>
            <td>" . $status . "</td>
            <td>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
        <td>" . $no++ . "</td>
        <td>" . $member->getResult()['nama'] . "</td>
        <td>" . $buku->getResult()['judul_buku'] . "</td>
        <td>" . $status . "</td>
        <td>
            <a href='peminjaman.php?id_edit=" . $id .  "' class='btn btn-warning' '>Edit</a>
            <a href='peminjaman.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
}

$member->close();
$buku->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_NAME", $data_member);
$tpl->replace("OPTION_BUKU", $data_buku);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
