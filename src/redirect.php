<?php

use GuzzleHttp\Client;

$client = new Client();

$response = $client->request(
    'POST',
    env('WEB_POS_FORM_ACTION'),
    ['json' => [
        'PaymentDealerAuthentication' => [
            'DealerCode' => $_POST['DealerCode'],
            'Username' => $_POST['Username'],
            'Password' => $_POST['Password'],
            'CheckKey' => $_POST['CheckKey']
        ],
        'WebPosRequest' => [
            'Amount' => $_POST['Amount'],
            'Currency' => $_POST['Currency'],
            'OtherTrxCode' => $_POST['OtherTrxCode'],
            'ClientWebPosTypeId' => $_POST['ClientWebPosTypeId'],
            'IsThreeD' => $_POST['IsThreeD'],
            'RedirectUrl' => $_POST['RedirectUrl'] . '?tx=' . $_POST['OtherTrxCode'],
            'Language' => $_POST['Language'],
            'ReturnHash' => $_POST['ReturnHash'],
        ]
    ]]);

$result = json_decode($response->getBody()->getContents());

if ($result->ResultCode == 'Success') {
    header('Location: ' . $result->Data);
    exit;
}

throw new Exception($result->ResultCode . ': ' . $result->ResultMessage);