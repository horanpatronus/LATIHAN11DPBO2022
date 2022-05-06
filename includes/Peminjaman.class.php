<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['tnim'];
        $id_buku = $data['tid_buku'];

        $query = "insert into peminjaman values ('', '$nim', '$id_buku', 'Sedang Dipinjam')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusPeminjaman($id)
    {

        $status = "Sudah Dikembalikan";
        $query = "update peminjaman set status = '$status' where id = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
