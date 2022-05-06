<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $member->delete($id);
    header("location:member.php");
}

$data_input = null;

if (empty($_GET['id_edit'])) {
    
    $data_input .= "<h2 class='card-title'>Add Member</h2>
                    <form action='member.php' method='POST'>
                        <div class='form-row'>
                            <div class='form-group col'>
                                <label for='tnim'>NIM</label>
                                <input type='text' class='form-control' name='tnim' />
                            </div>            
                        
                            <div class='form-group col'>
                                <label for='tname'>Nama</label>
                                <input type='text' class='form-control' name='tname' required />
                            </div>
                                                
                            <div class='form-group col'>
                                <label for='tjurusan'>Jurusan</label>
                                <input type='text' class='form-control' name='tjurusan' required />
                            </div>
                        </div>

                        <button type='submit' name='add' class='btn btn-primary mt-3'>Add</button>
                    </form>";

    // header("location:member.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $nim = $_GET['id_edit'];

    $member->getMemberByNIM($nim);
    list($nim, $nama, $jurusan) = $member->getResult();

    $data_input .= "<h2 class='card-title'>Update Member</h2>
                    <form action='member.php' method='POST'>
                        <div class='form-row'>
                            <div class='form-group col'>
                                <label for='tnim'>NIM</label>
                                <input type='text' class='form-control' name='tnim' value='" . $nim . "' readonly='readonly' />
                            </div>
                        
                            <div class='form-group col'>
                                <label for='tname'>Nama</label>
                                <input type='text' class='form-control' name='tname' value='" . $nama . "' />
                            </div>
                        
                            <div class='form-group col'>
                                <label for='tjurusan'>Jurusan</label>
                                <input type='text' class='form-control' name='tjurusan' value='" . $jurusan . "' />
                            </div>
                        </div>

                        <button type='submit' name='update' class='btn btn-primary mt-3'>Update</button>
                    </form>";

    // header("location:member.php");
}

if (isset($_POST['update'])) {
    //memanggil add
    $member->update($_POST);
    header("location:member.php");
}

$data = null;
$no = 1;
$member->getMember();

while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data .= "<tr>
        <td>" . $no++ . "</td>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $jurusan . "</td>
        <td>
        <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
        <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
        </td>
        </tr>";
}


$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);
$tpl->replace("DATA_INPUT", $data_input);
$tpl->write();
