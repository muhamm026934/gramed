<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once ('../conn/conf.php');
	    require_once ('../model/dbs.php');

        $connection = new Dbs($host,$user,$pass,$db);
        include "../model/m_proses.php";
        $result = array();
        $data = new Proses_sql($connection);

        @$target_dir = "../foto_buku/";
        @$file = $_FILES['files']['name'];
        @$file_tmp = $_FILES['files']['tmp_name'];
        @$id_buku = $_POST['id_buku'];
        @$judul = $_POST['judul'];
        @$penerbit = $_POST['penerbit'];
        @$pengarang = $_POST['pengarang'];
        @$tahun = $_POST['tahun'];
        @$description = $_POST['description'];
        @$id_user_input_buku = $_POST['id_user_input_buku'];
        @$date_user_input_buku = $_POST['date_user_input_buku'];
        
        @$data_book = $data->data_book(
            @$id_buku,
            @$judul,
            @$penerbit,
            @$pengarang,
            @$tahun,
            @$description,
            @$image_book,
            @$id_user_input_buku,
            @$date_user_input_buku,
        );
        @$row_buku = $data_book->fetch_object();
        @$id_buku_help = $row_buku->id_buku;
        @$judul_help = $row_buku->judul;
        @$penerbit_help = $row_buku->penerbit;
        @$pengarang_help = $row_buku->pengarang;
        @$tahun_help = $row_buku->tahun;
        @$description_help = $row_buku->description;
        @$image_book_help = $row_buku->image_book;
        
        if (@$file != null) {
            $temp = explode(".", @$file);
            $image_book = @$judul . '-' . @$penerbit . '.' . end($temp);
            @$target_file = $target_dir.basename(@$image_book);
        }else {
            @$image_book = @$image_book_help;
        }

        if (@$judul == "") {
            $response["value"] = "0";
            $response["message"] = "Judul Buku Harus Diisi";  
        }elseif($penerbit == ""){
            $response["value"] = "0";
            $response["message"] = "Data Penerbit Harus Diisi";
        }elseif($pengarang == ""){
            $response["value"] = "0";
            $response["message"] = "Data Pengarang Harus Diisi";
        }elseif(@$tahun == ""){
            $response["value"] = "0";
            $response["message"] = "Tahun Buku Harus Diisi";
        }elseif(@$description == ""){
            $response["value"] = "0";
            $response["message"] = "Deskripsi Buku Harus Diisi";
        }elseif($id_buku_help == @$id_buku && $judul_help == @$judul &&  $pengarang_help == $pengarang){
            $response["value"] = "0";
            $response["message"] = "Data Buku Sudah Ada";
        }else {
            @$add_book = $data->edit_book(
                @$id_buku,
                @$judul,
                @$penerbit,
                @$pengarang,
                @$tahun,
                @$description,
                @$image_book,
                @$id_user_input_buku,
                @$date_user_input_buku);
            if ($add_book) {
                $response["value"] = "1";
                $response["message"] = "Ubah Data Buku Berhasil";

                if (@$file != null) {
                    @$move_uploaded_files = move_uploaded_file(@$file_tmp,@$target_file);
                    if (@$move_uploaded_files) {
                        $response["value_image"] = "1";
                        $response["image_book"] = $image_book;
                    }else{
                        $response["value_image"] = "0";                    
                    }    
                }

            }else{
                $response["value"] = "0";
                $response["message"] = "Ubah Data Buku Gagal";
            }                  
        }
        array_push($result, $response);  
        echo json_encode($result);
    }
?>