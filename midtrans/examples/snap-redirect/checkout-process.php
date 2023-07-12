<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap-redirect:
// https://docs.midtrans.com/en/snap/integration-guide?id=alternative-way-to-display-snap-payment-page-via-redirect

namespace Midtrans;

require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-Zujj0fjUWA3-lL_XLEJe2cXo';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;

// Uncomment to enable sanitization
// Config::$isSanitized = true;

// Uncomment to enable 3D-Secure
// Config::$is3ds = true;

// Required

@$judul = $_GET['judul'];
@$qty = $_GET['qty'];
@$jml_bayar = $_GET['jml_bayar'];
@$rand = rand();
@$code_byr = $_GET['code_byr'];
@$nama = $_GET['nama'];

$transaction_details = array(
    'order_id' => $code_byr,
    'gross_amount' => $jml_bayar, // no decimal allowed for creditcard
);

// Optional
$item1_details = array(
    'id' => $code_byr,
    'price' => $jml_bayar,
    'quantity' => $qty,
    'name' => $judul
);

// Optional
// $item2_details = array(
//     'id' => 'a2',
//     'price' => 45000,
//     'quantity' => 1,
//     'name' => "Orange"
// );

// Optional
$item_details = array ($item1_details);

// Optional
$billing_address = array(
    'first_name'    => $nama
);

// Optional
// $shipping_address = array(
//     'first_name'    => "Obet",
//     'last_name'     => "Supriadi",
//     'address'       => "Manggis 90",
//     'city'          => "Jakarta",
//     'postal_code'   => "16601",
//     'phone'         => "08113366345",
//     'country_code'  => 'IDN'
// );

// Optional
$customer_details = array(
    'first_name'    => $nama
);

// Fill SNAP API parameter
$params = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

try {
    // Get Snap Payment Page URL
    $paymentUrl = Snap::createTransaction($params)->redirect_url;
  
    // Redirect to Snap Payment Page
    header('Location: ' . $paymentUrl);
}
catch (\Exception $e) {
    echo $e->getMessage();
}

function printExampleWarningMessage() {
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
