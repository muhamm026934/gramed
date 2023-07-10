<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);

        @$id_transaction = $_POST['id_transaction'];
        @$qty_pick = $_POST['qty_pick'];
        @$id_book = $_POST['id_book'];
        @$code_transaction = $_POST['code_transaction'];
        @$date_transaction = $_POST['date_transaction'];
        @$total_payment = $_POST['total_payment'];
        @$state_transaction = $_POST['state_transaction'];
        
        @$data_transaksi = $data->data_transaksi(
            @$id_transaction,
            @$qty_pick,
            @$id_book,
            @$code_transaction,
            @$date_transaction,
            @$total_payment,
            @$state_transaction
        );

        @$row_transaksi = $data_transaksi->fetch_object();

        if (@$id_transaction == "") {
            $response["value"] = "0";
            $response["message"] = "Ubah Transaksi Buku Gagal";  
        }else {
            @$edit_trans = $data->edit_trans(
                @$id_transaction,
                @$qty_pick,
                @$id_book,
                @$code_transaction,
                @$date_transaction,
                @$total_payment,
                @$state_transaction
            );
            if ($edit_trans) {
                $response["value"] = "1";
                $response["message"] = "Ubah Transaksi Buku Berhasil";                
            }else{
                $response["value"] = "0";
                $response["message"] = "Ubah Transaksi Buku Gagal";
            }                  
        }

        array_push($result, $response);  
        echo json_encode($result);
    }
?>