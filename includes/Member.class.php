<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function getMemberByNIM($nim)
    {
        $query = "SELECT * FROM member WHERE nim = '$nim'";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['tnim'];
        $name = $data['tname'];
        $jurusan = $data['tjurusan'];

        $query = "INSERT INTO member VALUES ('$nim', '$name', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($nim)
    {

        $query = "DELETE FROM member WHERE nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($data)
    {
        $nim = $data['tnim'];
        $name = $data['tname'];
        $jurusan = $data['tjurusan'];
        
        $query = "UPDATE member SET nama = '$name', jurusan = '$jurusan' WHERE nim = '$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
