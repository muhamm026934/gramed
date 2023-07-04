<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);
        @$id_buku = $_POST['id_buku'];
        @$target_dir = "../foto_buku/";
        @$data_book = $data->data_book(
            @$id_buku,
            @$judul,
            @$penerbit,
            @$pengarang,
            @$price,
            @$diskon,
            @$tahun,
            @$description,
            @$image_book,
            @$id_user_input_buku,
            @$date_user_input_buku,
        );
        @$row_buku = $data_book->fetch_object();
        @$id_buku_help = $row_buku->id_buku;
        @$image_book_help = $row_buku->image_book;

        if (@$id_buku != ""|| @$id_buku != null) {
            @$delete_book = $data->delete_book(
                @$id_buku,
                @$judul,
                @$penerbit,
                @$pengarang,
                @$price,
                @$diskon,
                @$tahun,
                @$description,
                @$image_book,
                @$id_user_input_buku,
                @$date_user_input_buku,
            );
                           
                if (@$delete_book) {
                    $response["value"] = "1";
                    $response["message"] = "Hapus Buku Berhasil";
                    if (file_exists(@$target_dir.$image_book_help)) {
                        $delete  = unlink(@$target_dir.$image_book_help);
                        $response["value_delete_image"] = "1";
                    }                    
                }else{
                    $response["value"] = "0";
                    $response["message"] = "Hapus Buku Gagal";	
                }  

        }else {
            $response["value"] = "0";
            $response["message"] = "Hapus Buku Gagal";	               
        }
        array_push($result, $response); 
        echo json_encode($result);
    }
?>