<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for sample HTTP notifications:
// https://docs.midtrans.com/en/after-payment/http-notification?id=sample-of-different-payment-channels

namespace Midtrans;

require_once dirname(__FILE__) . '/../Midtrans.php';
Config::$isProduction = false;
Config::$serverKey = 'SB-Mid-server-Zujj0fjUWA3-lL_XLEJe2cXo';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

try {
    $notif = new Notification();
}
catch (\Exception $e) {
    exit($e->getMessage());
}

$notif = $notif->getResponse();
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;


if ($transaction == 'settlement') {
    $servername = "localhost";
    $username = "stat9742_stra46";
    $password = "Trakindo#46";
    $dbname = "stat9742_dg_gramed";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE tb_transaction SET state_transaction='$transaction' WHERE code_transaction = '$order_id'";
    $conn->query($sql);
    $conn->close();

} else if ($transaction == 'pending') {
    $servername = "localhost";
    $username = "stat9742_stra46";
    $password = "Trakindo#46";
    $dbname = "stat9742_dg_gramed";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE tb_transaction SET state_transaction='$transaction' WHERE code_transaction = '$order_id'";
    $conn->query($sql);
    $conn->close();
} else if ($transaction == 'deny') {
    $servername = "localhost";
    $username = "stat9742_stra46";
    $password = "Trakindo#46";
    $dbname = "stat9742_dg_gramed";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE tb_transaction SET state_transaction='$transaction' WHERE code_transaction = '$order_id'";
    $conn->query($sql);
    $conn->close();
} else if ($transaction == 'expire') {
    $servername = "localhost";
    $username = "stat9742_stra46";
    $password = "Trakindo#46";
    $dbname = "stat9742_dg_gramed";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE tb_transaction SET state_transaction='$transaction' WHERE code_transaction = '$order_id'";
    $conn->query($sql);
    $conn->close();
} else if ($transaction == 'cancel') {
    $servername = "localhost";
    $username = "stat9742_stra46";
    $password = "Trakindo#46";
    $dbname = "stat9742_dg_gramed";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "UPDATE tb_transaction SET state_transaction='$transaction' WHERE code_transaction = '$order_id'";
    $conn->query($sql);
    $conn->close();
}

function printExampleWarningMessage() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
    }
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    }   
}
