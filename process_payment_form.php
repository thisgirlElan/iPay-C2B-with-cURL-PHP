<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tel = $_POST['tel'];
    $ttl = $_POST['ttl'];
    $eml = $_POST['eml'];
    $curr = $_POST['curr'];

    $oid = "iPayLBKTest" . substr(md5(uniqid(rand(), true)), 0, 7);
    $inv = "iPayLBKTest" . substr(md5(uniqid(rand(), true)), 0, 7);

    $live = "1"; // Set to "1" on prod
    $vid = "demo"; // Your vendor ID
    $cbk = "your-url/test_script/payment_callback.php"; // Your callback URL
    $p1 = "";
    $p2 = "";
    $p3 = "";
    $p4 = "";
    $crl = "0";
    $cst = "0";

    // autopay
    $autopay = "1";
    // channels
    $mpesa = "0";
    $airtel = "0";
    $equity = "0";
    $pesalink = "0";
    $bonga = "0";
    $vooma = "0";
    $unionpay = "0";
    // to disable card programatically uncomment the below, it will display only the card option by default as it is
    // $debitcard = '0';
    // $creditcard = '0';
    $lbk = "https://www.google.com/";

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
        'crl' => $crl,
    );

    $datastring = implode('', $fields);

    $hashkey = 'demoCHANGED'; // Change to your API KEY on prod
    $generated_hash = hash_hmac('sha1', $datastring, $hashkey);

    $fields['hsh'] = $generated_hash;

    $postData = http_build_query($fields);

    $actionUrl = "https://payments.ipayafrica.com/v3/ke?autopay={$autopay}&mpesa={$mpesa}&airtel={$airtel}&equity={$equity}&pesalink={$pesalink}&bonga={$bonga}&vooma={$vooma}&unionpay={$unionpay}&lbk={$lbk}";

    $ch = curl_init($actionUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'
    ));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        echo 'cURL error: ' . htmlspecialchars($error);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $redirectUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        if ($http_code >= 200 && $http_code < 300) {
            header("Location: $redirectUrl");
            exit();
            // echo 'Response: ' . htmlspecialchars($response);
        } else {
            echo 'HTTP Error: ' . $http_code . ' Response: ' . htmlspecialchars($response);
        }
    }

    curl_close($ch);
} else {
    echo 'Invalid request method. Please use POST.';
}
