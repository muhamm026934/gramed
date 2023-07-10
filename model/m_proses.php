<?php
    class Db_table{
        protected $tb_user = 'tb_user';
        protected $tb_book = 'tb_book';
        protected $tb_stock_book = 'tb_stock_book';
        protected $tb_transaction = 'tb_transaction';
                      
		protected $sql_select_distinct = "SELECT DISTINCT ";
		protected $sql_select = "SELECT * FROM ";
		protected $sql_insert = "INSERT INTO ";
		protected $sql_update = "UPDATE ";
		protected $sql_delete = "DELETE FROM ";
		protected $sql_select_count = "SELECT COUNT"; 
        protected $sql_select_sum = "SELECT SUM";    
    }

    class Proses_sql extends Db_table{
        private $mysqli;
        
        function __construct($conn){
            $this->mysqli = $conn;
        }

        public function login(
            $username = null,
            $pasword = null){
            if ($username != null && $pasword != null) {
                $table = $this->tb_user;
                $select = $this->sql_select;                
                $sql = $select;	
                $sql.= $table;
                $sql.= " WHERE username = ? AND password = ?";
                $db = $this->mysqli->conf;
                $query = $db->prepare($sql) or die($db->error);
                $query->bind_param("ss",$username,$pasword); 
                if ($query->execute()) {
                    $result = $query->get_result();
                }                           
            }		
            return @$result;
        }     
// Tabel User
        public function data_user($id_user = null, $name = null){
            $db = $this->mysqli->conf;
            $table = $this->tb_user;
            $select = $this->sql_select;
            $sql= $select;
            $sql.= $table;
            if (@$id_user != null || @$id_user != "") {
                $sql.= " WHERE id_user = '$id_user' ";
            }elseif (@$name != null || @$name != "") {
                $sql.= " WHERE name = '$name' ";
            }else {
                $sql.= " ORDER BY name ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function add_user(
            $id_user = null,
            $name = null,
            $username = null,
            $password = null,
            $address = null,
            $level = null,
            $email = null,
            $no_telp = null,
            $token = null){
    
            $db = $this->mysqli->conf;
            $table = $this->tb_user;
            $insert = $this->sql_insert;
            $sql = $insert;
            $sql.= $table;
            $sql.= " SET 
            id_user = '',
            name = '$name',
            username = '$username',
            password = '$password',
            address = '$address',
            level = '$level',
            email = '$email',
            no_telp = '$no_telp',
            token = '$token'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function edit_user(
            $id_user = null,
            $name = null,
            $username = null,
            $password = null,
            $address = null,
            $level = null,
            $email = null,
            $no_telp = null,
            $token = null){
    
            $db = $this->mysqli->conf;
            $table = $this->tb_user;
            $update = $this->sql_update;
            $sql = $update;
            $sql.= $table;
            $sql.= " SET 
            name = '$name',
            username = '$username',
            password = '$password',
            address = '$address',
            level = '$level',
            email = '$email',
            no_telp = '$no_telp',
            token = '$token'
            WHERE id_user = '$id_user'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function delete_user(
            $id_user = null,
            $name = null,
            $username = null,
            $password = null,
            $address = null,
            $level = null,
            $email = null,
            $no_telp = null,
            $token = null){
    
            $db = $this->mysqli->conf;
            $table = $this->tb_user;
            $delete = $this->sql_delete;
            $sql = $delete;
            $sql.= $table;
            $sql.= " WHERE id_user = '$id_user'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

// Tabel buku
        public function data_book_home(
            $id_buku = null,
            $judul = null,
            $penerbit = null,
            $pengarang = null,
            $price = null,
            $diskon = null,
            $tahun = null,
            $description = null,
            $image_book = null,
            $id_user_input_buku = null,
            $date_user_input_buku = null){
            $db = $this->mysqli->conf;
            $table = $this->tb_book;
            $select = $this->sql_select;
            $sql= $select;
            $sql.= $table;
            if (@$id_buku != null) {
                $sql.= " WHERE id_buku = '$id_buku' ";
            }elseif (@$diskon == "0") {
                $sql.= " WHERE diskon = '0'";
            }elseif (@$diskon != "0") {
                $sql.= " WHERE diskon != '0'";
            }else {
                $sql.= " ORDER BY judul ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }
        public function data_book(
            $id_buku = null,
            $judul = null,
            $penerbit = null,
            $pengarang = null,
            $price = null,
            $diskon = null,
            $tahun = null,
            $description = null,
            $image_book = null,
            $id_user_input_buku = null,
            $date_user_input_buku = null){
            $db = $this->mysqli->conf;
            $table = $this->tb_book;
            $select = $this->sql_select;
            $sql= $select;
            $sql.= $table;
            if (@$id_buku != null) {
                $sql.= " WHERE id_buku = '$id_buku' ";
            }elseif (@$judul != null && @$penerbit != "") {
                $sql.= " WHERE judul = '$judul' AND penerbit = '$penerbit'";
            }else {
                $sql.= " ORDER BY judul ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function add_book(
            $id_buku = null,
            $judul = null,
            $penerbit = null,
            $pengarang = null,
            $price = null,
            $diskon = null,
            $tahun = null,
            $description = null,
            $image_book = null,
            $id_user_input_buku = null,
            $date_user_input_buku = null){

            $db = $this->mysqli->conf;
            $table = $this->tb_book;
            $insert = $this->sql_insert;
            $sql = $insert;
            $sql.= $table;
            $sql.= " SET 
            id_buku = '',
            judul = '$judul',
            penerbit = '$penerbit',
            pengarang = '$pengarang',
            price = '$price',
            diskon = '$diskon',
            tahun = '$tahun',
            description = '$description',
            image_book = '$image_book',
            id_user_input_buku = '$id_user_input_buku',
            date_user_input_buku = '$date_user_input_buku'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function edit_book(
            $id_buku = null,
            $judul = null,
            $penerbit = null,
            $pengarang = null,
            $price = null,
            $diskon = null,
            $tahun = null,
            $description = null,
            $image_book = null,
            $id_user_input_buku = null,
            $date_user_input_buku = null){

            $db = $this->mysqli->conf;
            $table = $this->tb_book;
            $update = $this->sql_update;
            $sql = $update;
            $sql.= $table;
            $sql.= " SET 
            judul = '$judul',
            penerbit = '$penerbit',
            pengarang = '$pengarang',
            price = '$price',
            diskon = '$diskon',
            tahun = '$tahun',
            description = '$description',
            image_book = '$image_book',
            id_user_input_buku = '$id_user_input_buku',
            date_user_input_buku = '$date_user_input_buku'
            WHERE id_buku = '$id_buku'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function delete_book(
            $id_buku = null,
            $judul = null,
            $penerbit = null,
            $pengarang = null,
            $price = null,
            $diskon = null,
            $tahun = null,
            $description = null,
            $id_user_input_buku = null,
            $date_user_input_buku = null){

            $db = $this->mysqli->conf;
            $table = $this->tb_book;
            $delete = $this->sql_delete;
            $sql = $delete;
            $sql.= $table;
            $sql.= " WHERE id_buku = '$id_buku'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        // Tabel stock buku
        public function data_stock_book(
            $id_stock = null,
            $id_book = null,
            $qty_gr = null,
            $date_gr = null,
            $no_note = null,
            $id_user_input_stock = null,
            $date_user_input_stock = null
            ){
            $db = $this->mysqli->conf;
            $table = $this->tb_stock_book;
            $select = $this->sql_select;
            $sql= $select;
            $sql.= $table;
            if (@$id_stock != null) {
                $sql.= " WHERE id_stock = '$id_stock' ";
            }elseif (@$id_book != null && @$no_note != "") {
                $sql.= " WHERE id_book = '$id_book' AND no_note = '$no_note'";
            }else {
                $sql.= " ORDER BY id_book ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function data_stock_book_qty_gr(
            $id_stock = null,
            $id_book = null,
            $qty_gr = null,
            $date_gr = null,
            $no_note = null,
            $id_user_input_stock = null,
            $date_user_input_stock = null
            ){
            $db = $this->mysqli->conf;
            $table = $this->tb_stock_book;
            $sql_select_sum = $this->sql_select_sum;
            $sql= $sql_select_sum;
            $sql.="(qty_gr) AS total_qty_gr FROM ";
            $sql.= $table;
            if (@$id_stock != null) {
                $sql.= " WHERE id_stock = '$id_stock' ";
            }elseif (@$id_book != null) {
                $sql.= " WHERE id_book = '$id_book'";
            }else {
                $sql.= " ORDER BY id_book ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function add_stock_book(
            $id_stock = null,
            $id_book = null,
            $qty_gr = null,
            $date_gr = null,
            $no_note = null,
            $id_user_input_stock = null,
            $date_user_input_stock = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_stock_book;
            $insert = $this->sql_insert;
            $sql = $insert;
            $sql.= $table;
            $sql.= " SET 
            id_stock = '',
            id_book = '$id_book',
            qty_gr = '$qty_gr',
            date_gr = '$date_gr',
            no_note = '$no_note',
            id_user_input_stock = '$id_user_input_stock',
            date_user_input_stock = '$date_user_input_stock'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function edit_stock_book(
            $id_stock = null,
            $id_book = null,
            $qty_gr = null,
            $date_gr = null,
            $no_note = null,
            $id_user_input_stock = null,
            $date_user_input_stock = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_stock_book;
            $update = $this->sql_update;
            $sql = $update;
            $sql.= $table;
            $sql.= " SET 
            id_book = '$id_book',
            qty_gr = '$qty_gr',
            date_gr = '$date_gr',
            no_note = '$no_note',
            id_user_input_stock = '$id_user_input_stock',
            date_user_input_stock = '$date_user_input_stock'
            WHERE id_stock = '$id_stock'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function delete_stock_book(
            $id_stock = null,
            $id_book = null,
            $qty_gr = null,
            $date_gr = null,
            $no_note = null,
            $id_user_input_stock = null,
            $date_user_input_stock = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_stock_book;
            $delete = $this->sql_delete;
            $sql = $delete;
            $sql.= $table;
            $sql.= " WHERE id_stock = '$id_stock'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }         

        // Tabel transaksi buku
        public function data_transaksi(
            $id_transaction = null,
            $qty_pick = null,
            $id_book = null,
            $code_transaction = null,
            $date_transaction = null,
            $total_payment = null,
            $state_transaction = null,
            $id_user = null,
            $alamat = null
            ){
            $db = $this->mysqli->conf;
            $table = $this->tb_transaction;
            $select = $this->sql_select;
            $sql= $select;
            $sql.= $table;
            if (@$id_transaction != null) {
                $sql.= " WHERE id_transaction = '$id_transaction' ";
            }elseif (@$id_book != null) {
                $sql.= " WHERE id_book = '$id_book'";
            }elseif (@$code_transaction != null) {
                $sql.= " WHERE code_transaction = '$code_transaction'";
            }else {
                $sql.= " ORDER BY date_transaction ASC";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function data_transaksi_total_qty(
            $id_transaction = null,
            $qty_pick = null,
            $id_book = null,
            $code_transaction = null,
            $date_transaction = null,
            $total_payment = null,
            $state_transaction = null,
            $id_user = null,
            $alamat = null
            ){
            $db = $this->mysqli->conf;
            $table = $this->tb_transaction;
            $sql_select_sum = $this->sql_select_sum;
            $sql= $sql_select_sum;
            $sql.="(qty_pick) AS total_qty_pick FROM ";
            $sql.= $table;
            if (@$id_book != null) {
                $sql.= " WHERE id_book = '$id_book' ";
            }
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function add_trans(
            $id_transaction = null,
            $qty_pick = null,
            $id_book = null,
            $code_transaction = null,
            $date_transaction = null,
            $total_payment = null,
            $state_transaction = null,
            $id_user = null,
            $alamat = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_transaction;
            $insert = $this->sql_insert;
            $sql = $insert;
            $sql.= $table;
            $sql.= " SET 
            id_transaction = '',
            qty_pick = '$qty_pick',
            id_book = '$id_book',
            code_transaction = '$code_transaction',
            date_transaction = '$date_transaction',
            total_payment = '$total_payment',
            state_transaction = '$state_transaction',
            id_user = '$id_user',
            alamat = '$alamat'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  

        public function edit_trans(
            $id_transaction = null,
            $qty_pick = null,
            $id_book = null,
            $code_transaction = null,
            $date_transaction = null,
            $total_payment = null,
            $state_transaction = null,
            $id_user = null,
            $alamat = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_transaction;
            $update = $this->sql_update;
            $sql = $update;
            $sql.= $table;
            $sql.= " SET 
            qty_pick = '$qty_pick',
            id_book = '$id_book',
            code_transaction = '$code_transaction',
            date_transaction = '$date_transaction',
            total_payment = '$total_payment',
            state_transaction = '$state_transaction',
            id_user = '$id_user',
            alamat = '$alamat'
            WHERE id_transaction = '$id_transaction'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }

        public function delete_trans(
            $id_transaction = null,
            $qty_pick = null,
            $id_book = null,
            $code_transaction = null,
            $date_transaction = null,
            $total_payment = null,
            $state_transaction = null,
            $id_user = null,
            $alamat = null
            ){

            $db = $this->mysqli->conf;
            $table = $this->tb_transaction;
            $delete = $this->sql_delete;
            $sql = $delete;
            $sql.= $table;
            $sql.= " WHERE id_transaction = '$id_transaction'
            ";		
            
            $query = $db->query($sql) or die($db->error);
            return $query;
        }  
        
        
        function __destruct()
        {
            $db = $this->mysqli->conf;
            $db = $db->close();
        }
    }
?>