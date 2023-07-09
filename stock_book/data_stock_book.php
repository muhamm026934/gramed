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
        @$date_gr = $_POST['date_gr'];
        @$no_note = $_POST['no_note'];

        @$data_stock_book = $data->data_stock_book(
            @$id_stock,
            @$id_book,
            @$qty_gr,
            @$date_gr,
            @$no_note,
            @$id_user_input_stock,
            @$date_user_input_stock
        );

            while ($row_stock_book = $data_stock_book->fetch_object()) {
                if (isset($row_stock_book)) {
                $id_stock = $row_stock_book->id_stock;
                $id_book = $row_stock_book->id_book;
                $qty_gr = $row_stock_book->qty_gr;
                $date_gr = $row_stock_book->date_gr;
                $no_note = $row_stock_book->no_note;
                $id_user_input_stock = $row_stock_book->id_user_input_stock;
                $date_user_input_stock = $row_stock_book->date_user_input_stock;
                }else{
                $id_stock = "";	
                $id_book = "";	
                $qty_gr = "";
                $date_gr = "";
                $no_note = "";
                $id_user_input_stock = "";
                $date_user_input_stock = "";
                }
            $b['id_stock'] = $id_stock; 
            $b['id_book'] = $id_book; 
            $b['qty_gr'] = $qty_gr;
            $b['date_gr'] = $date_gr; 
            $b['no_note'] = $no_note;
            $b['id_user_input_stock'] = $id_user_input_stock;  
            $b['date_user_input_stock'] = $date_user_input_stock;  

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