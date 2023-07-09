<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);

        @$id_stock = $_POST['id_stock'];
        @$id_book = $_POST['id_book'];
        @$qty_gr = $_POST['qty_gr'];
        @$date_gr = $_POST['date_gr'];
        @$no_note = $_POST['no_note'];
        @$id_user_input_stock = $_POST['id_user_input_stock'];
        @$date_user_input_stock = $_POST['date_user_input_stock'];
        
        @$data_stock_book = $data->data_stock_book(
            @$id_stock,
            @$id_book,
            @$qty_gr,
            @$date_gr,
            @$no_note,
            @$id_user_input_stock,
            @$date_user_input_stock
        );
        @$row_stock_buku = $data_stock_book->fetch_object();
        @$id_stock_help = $row_stock_buku->id_stock;
        @$id_book_help = $row_stock_buku->id_book;
        @$qty_gr_help = $row_stock_buku->qty_gr;
        @$date_gr_help = $row_stock_buku->date_gr;
        @$no_note_help = $row_stock_buku->no_note;
        @$id_user_input_stock_help = $row_stock_buku->id_user_input_stock;
        @$date_user_input_stock_help = $row_stock_buku->date_user_input_stock;
        
        if (@$qty_gr == "") {
            $response["value"] = "0";
            $response["message"] = "Jumlah Buku Harus Diisi";  
        }elseif($date_gr == ""){
            $response["value"] = "0";
            $response["message"] = "Tanggal Terima Penerbit Harus Diisi";
        }elseif($no_note == ""){
            $response["value"] = "0";
            $response["message"] = "Nomor Nota Harus Diisi";
        }else {
            @$edit_stock_book = $data->edit_stock_book(
                @$id_stock,
                @$id_book,
                @$qty_gr,
                @$date_gr,
                @$no_note,
                @$id_user_input_stock,
                @$date_user_input_stock
            );
            if ($edit_stock_book) {
                $response["value"] = "1";
                $response["message"] = "Ubah Data Stock Buku Berhasil";

            }else{
                $response["value"] = "0";
                $response["message"] = "Ubah Data Stock Buku Gagal";
            }                  
        }
        array_push($result, $response);  
        echo json_encode($result);
    }
?>