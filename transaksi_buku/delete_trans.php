<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);
        @$id_transaction = $_POST['id_transaction'];


        if (@$id_transaction != ""|| @$id_transaction != null) {
            @$delete_trans = $data->delete_trans(
                @$id_transaction,
                @$qty_pick,
                @$id_book,
                @$code_transaction,
                @$date_transaction,
                @$total_payment,
                @$state_transaction,
                @$id_user,
                @$alamat
            );
                           
                if (@$delete_trans) {
                    $response["value"] = "1";
                    $response["message"] = "Hapus Transaksi Buku Berhasil";                  
                }else{
                    $response["value"] = "0";
                    $response["message"] = "Hapus Transaksi Buku Gagal";	
                }  

        }else {
            $response["value"] = "0";
            $response["message"] = "Hapus Transaksi Buku Gagal";	               
        }
        array_push($result, $response); 
        echo json_encode($result);
    }
?>