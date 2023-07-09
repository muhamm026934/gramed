<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);
        @$id_stock = $_POST['id_stock'];


        if (@$id_stock != ""|| @$id_stock != null) {
            @$delete_stock_book = $data->delete_stock_book(
                @$id_stock,
                @$id_book,
                @$qty_gr,
                @$date_gr,
                @$no_note,
                @$id_user_input_stock,
                @$date_user_input_stock
            );
                           
                if (@$delete_stock_book) {
                    $response["value"] = "1";
                    $response["message"] = "Hapus Stock Buku Berhasil";                  
                }else{
                    $response["value"] = "0";
                    $response["message"] = "Hapus Stock Buku Gagal";	
                }  

        }else {
            $response["value"] = "0";
            $response["message"] = "Hapus Stock Buku Gagal";	               
        }
        array_push($result, $response); 
        echo json_encode($result);
    }
?>