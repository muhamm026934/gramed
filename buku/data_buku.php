<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);

        @$id_buku = $_POST['id_buku'];
        @$judul = $_POST['judul'];
        @$penerbit = $_POST['penerbit'];
        @$tahun = $_POST['tahun'];

        @$data_book = $data->data_book(
            @$id_buku,
            @$judul,
            @$penerbit,
            @$pengarang,
            @$tahun,
            @$description,
            @$image_book,
            @$id_user_input_buku,
            @$date_user_input_buku
        );

            while ($row_book = $data_book->fetch_object()) {
                if (isset($row_book)) {
                $id_buku = $row_book->id_buku;
                $judul = $row_book->judul;
                $penerbit = $row_book->penerbit;
                $pengarang = $row_book->pengarang;
                $tahun = $row_book->tahun;
                $description = $row_book->description;
                $image_book = $row_book->image_book;
                $id_user_input_buku = $row_book->id_user_input_buku;         
                $date_user_input_buku = $row_book->date_user_input_buku;  
                }else{
                $id_buku = "";	
                $judul = "";	
                $penerbit = "";
                $pengarang = "";
                $tahun = "";	
                $description = "";
                $image_book = "";
                $id_user_input_buku = "";
                $date_user_input_buku = "";
                }
            $b['id_buku'] = $id_buku; 
            $b['judul'] = $judul; 
            $b['penerbit'] = $penerbit;
            $b['pengarang'] = $pengarang;    
            $b['tahun'] = $tahun;   
            $b['description'] = $description;  
            $b['image_book'] = $image_book;  
            $b['id_user_input_buku'] = $id_user_input_buku;  
            $b['date_user_input_buku'] = $date_user_input_buku;   
            array_push($result, $b);

        }
        echo json_encode($result);
    }
?>