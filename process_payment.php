<?php
// this is an example that caters for when you don't really require a form to process data. 
// To run this, simply have it run from your server, localhost or ngrok
// update lines 7 to 9 with your credentials to simulate the payment once the file runs and redirects to the gateway.
// update line 17 with where you want your callback delivered - you could also use webhook.site to get a url to use for testing

$tel = "07xxxxxxxx";
$ttl = "5";
$eml = "example@mail.com";
$curr = "KES";

$oid = substr(md5(uniqid(rand(), true)), 0, 7);
$inv = "iPay" . substr(md5(uniqid(rand(), true)), 0, 7);

$live = "0"; // Set to "1" on prod
$vid = "test"; // Your vendor ID
$cbk = "your-server-url/test_script/payment_callback.php"; // Your callback URL - this will display the callback as JSON on payment completion.
$p1 = "";
$p2 = "";
$p3 = "";
$p4 = "";
$crl = "2";
$cst = "1";

$fields = array(
    'live' => $live,
    'oid' => $oid,
    'inv' => $inv,
    'ttl' => $ttl,
    'tel' => $tel,
    'eml' => $eml,
    'vid' => $vid,
    'curr' => $curr,
    'p1' => $p1,
    'p2' => $p2,
    'p3' => $p3,
    'p4' => $p4,
    'cbk' => $cbk,
    'cst' => $cst,
    'crl' => $crl
);

$datastring = implode('', $fields);

$hashkey = "demoCHANGED"; // Change to your API KEY on prod
$generated_hash = hash_hmac('sha1', $datastring, $hashkey);

$fields['hsh'] = $generated_hash;

$postData = http_build_query($fields);

$actionUrl = "https://payments.ipayafrica.com/v3/ke";

$ch = curl_init($actionUrl);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);

// Enables gateway rendering by redirection, if rendered as is, it shows html text. This will ensure it displays the form.

if ($response === false) {
    $error = curl_error($ch);
    echo 'cURL error: ' . htmlspecialchars($error);
} else {
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $redirectUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    if ($http_code >= 200 && $http_code < 300) {
        header("Location: $redirectUrl");
        exit();
    } else {
        echo 'HTTP Error: ' . $http_code . ' Response: ' . htmlspecialchars($response);
    }
}

curl_close($ch);
