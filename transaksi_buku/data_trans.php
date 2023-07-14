<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);
        @$action = $_POST['ACTION'];
        @$id_transaction = $_POST['id_transaction'];
        @$qty_pick = $_POST['qty_pick'];
        @$id_book = $_POST['id_book'];
        @$code_transaction = $_POST['code_transaction'];
        @$date_transaction = $_POST['date_transaction'];
        @$total_payment = $_POST['total_payment'];
        @$state_transaction = $_POST['state_transaction'];
        @$level = $_POST['level'];
        @$id_user = $_POST['id_user'];

        if ($level == "admin") {
            @$data_transaksi = $data->data_transaksi(
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
        }else{
                @$data_transaksi = $data->data_transaksi_user(
                    @$id_transaction,
                    @$qty_pick,
                    @$id_book,
                    @$code_transaction,
                    @$date_transaction,
                    @$total_payment,
                    @$state_transaction,
                    @$id_user,
                    @$alamat,
                    @$action
                ); 
           
        }
            while ($row_transaksi = $data_transaksi->fetch_object()) {
                if (isset($row_transaksi)) {
                $id_transaction = $row_transaksi->id_transaction;
                $qty_pick = $row_transaksi->qty_pick;
                $id_book = $row_transaksi->id_book;
                $code_transaction = $row_transaksi->code_transaction;
                $date_transaction = $row_transaksi->date_transaction;
                $total_payment = $row_transaksi->total_payment;
                $total_payment_price = round($total_payment,2);
                $state_transaction = $row_transaksi->state_transaction;
                $id_user = $row_transaksi->id_user;
                $alamat = $row_transaksi->alamat;
                }else{
                $id_transaction = "";	
                $qty_pick = "";	
                $id_book = "";
                $code_transaction = "";
                $date_transaction = "";
                $total_payment = "";
                $total_payment_price = "";
                $state_transaction = "";
                $id_user = "";
                $alamat = "";
                }
            $b['id_transaction'] = $id_transaction; 
            $b['qty_pick'] = $qty_pick; 
            $b['id_book'] = $id_book;
            $b['code_transaction'] = $code_transaction; 
            $b['date_transaction'] = $date_transaction; 
            $b['total_payment'] = $total_payment; 
            $b['total_payment_price'] = strval(number_format($total_payment_price,2,',','.'));     
            $b['state_transaction'] = $state_transaction; 
            $b['id_user'] = $id_user; 
            $b['alamat'] = $alamat; 

            @$data_stock_book_qty_gr = $data->data_stock_book_qty_gr(
                @$id_stock,
                @$id_book,
                @$qty_gr,
                @$date_gr,
                @$no_note,
                @$id_user_input_stock,
                @$date_user_input_stock
            );
                $row_stock_book = $data_stock_book_qty_gr->fetch_object();
                    if (isset($row_stock_book)) {
                    @$total_qty_gr = $row_stock_book->total_qty_gr;
                    }else{
                    @$total_qty_gr = "0";
                    }
                $b['total_qty_gr'] = @$total_qty_gr == null ? "0":@$total_qty_gr;

                @$id_buku = $id_book;
                @$data_book = $data->data_book(
                    @$id_book,
                    @$judul,
                    @$penerbit,
                    @$pengarang,
                    @$price,
                    @$diskon,
                    @$tahun,
                    @$description,
                    @$image_book,
                    @$id_user_input_buku,
                    @$date_user_input_buku
                );
        
                    $row_book = $data_book->fetch_object();
                        if (isset($row_book)) {
                        $id_buku = $row_book->id_buku;
                        $judul = $row_book->judul;
                        $penerbit = $row_book->penerbit;
                        $pengarang = $row_book->pengarang;
                        $price = $row_book->price;
                        $diskon = $row_book->diskon;
                        $potongan_harga = $price * $diskon / 100;
                        $net_price = round($price - $potongan_harga,2);
                        $tahun = $row_book->tahun;
                        $description = $row_book->description;
                        $image_book = $row_book->image_book;
                        $id_user_input_buku = $row_book->id_user_input_buku;         
                        $date_user_input_buku = $row_book->date_user_input_buku;  
                        }else{
                        $id_buku = "";	
                        $judul = "";	
                        $penerbit = "";
                        $price = "";
                        $diskon = "";
                        $potongan_harga = "";
                        $net_price = "";
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
                    $b['price'] = strval(number_format($price,2,',','.'));     
                    $b['price_buku'] = $price;
                    $b['diskon'] = strval($diskon); 
                    $b['potongan_harga'] = strval(number_format($potongan_harga,2,',','.'));  
                    $b['harga_jual'] = strval($net_price); 
                    $b['net_price'] = strval(number_format($net_price,2,',','.'));  
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