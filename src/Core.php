<?php

namespace Vpos;

use GuzzleHttp\Client;

class Core
{
    const PAGE_NAME_HOMEPAGE = 'home';
    const PAGE_NAME_RESULT = 'result';
    const PAGE_NAME_NOT_FOUND = 'error';
    const PAGE_NAME_REVIEW = 'review';

    const ERROR_MESSAGES = [
        'PaymentDealer.CheckPaymentDealerAuthentication.InvalidRequest' => 'The CheckKey may be bad, or the object may be bad, or the JSON may be corrupt',
        'PaymentDealer.CheckPaymentDealerAuthentication.InvalidAccount' => 'No such dealer was found, Dealer code, dealer username and/or password were entered incorrectly.',
        'PaymentDealer.CheckPaymentDealerAuthentication.VirtualPosNotFound' => 'There is no virtual pos definition for this dealer.',
        'PaymentDealer.CheckDealerPaymentLimits.DailyDealerLimitExceeded' => 'Any of the daily limits defined for the dealer have been exceeded.',
        'PaymentDealer.CheckDealerPaymentLimits.DailyCardLimitExceeded' => 'No more transactions can be made using this card during the day..',
        'PaymentDealer.CheckCardInfo.InvalidCardInfo' => 'There is an error in the card information',
        'PaymentDealer.DoDirectPayment.ThreeDRequired' => 'There is an obligation to send 3d payment for the dealer, Non-3D payment cannot be sent.',
        'PaymentDealer.DoDirectPayment.InstallmentNotAvailableForForeignCurrencyTransaction' => 'Installments cannot be made in foreign currency.',
        'PaymentDealer.DoDirectPayment.ThisInstallmentNumberNotAvailableForDealer' => 'This number of installments cannot be made for this dealer.',
        'PaymentDealer.DoDirectPayment.InvalidInstallmentNumber' => 'The number of installments is between 2 and 12.',
        'PaymentDealer.DoDirectPayment.ThisInstallmentNumberNotAvailableForVirtualPos' => 'Virtual Pos does not allow this number of installments.',
        'EX' => 'An unexpected error has occurred'
    ];

    public $pageName;

    function __construct()
    {
        $this->pageName =
            array_key_exists('tx', $_GET) &&
            array_key_exists('hashValue', $_POST) &&
            $this->checkWebPosHash() ?
                self::PAGE_NAME_RESULT :
                self::pageParameter();
    }

    function getPageName()
    {
        return $this->pageName;
    }

    function setPageName($newName)
    {
        $this->pageName = $newName;
    }

    function getRelativePagePath()
    {
        return '../pages/' . $this->getPageName() . '.php';
    }

    function getAbsolutePagePath()
    {
        return __DIR__ . '/' . $this->getRelativePagePath();
    }

    function getClientIp()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    function isPageExists()
    {
        return file_exists($this->getAbsolutePagePath());
    }

    static function pageParameter()
    {
        return isset($_GET['p']) ? $_GET['p'] : self::PAGE_NAME_HOMEPAGE;
    }

    private function checkWebPosHash($clearDb = false)
    {
        $jsonDb = new \Jajo\JSONDB(__DIR__);

        $codeForHash = $jsonDb->select('codeForHash')
            ->from('db.json')
            ->get();

        if ($clearDb)
            $jsonDb->update(['codeForHash' => ''])
                ->from('db.json')
                ->trigger();

        return hash(
                'sha256',
                $codeForHash[0]['codeForHash'] . 'T'
            ) === $_POST['hashValue'];
    }

    private function loadPageData()
    {
        switch ($this->getPageName()) {
            case 'form':
                $type = new \Vpos\Type();
                $parameters = $type->getParameters();
                $action = $type->getAction();

                $data = [
                    'Amount' => 27.3,
                    'ClientIP' => $this->getClientIp(),
                    'Software' => 'Custom PHP',
                    'OtherTrxCode' => 'FO' . rand(1000, 10000)
                ];
                unset($parameters['CheckKey']);

                return [
                    'dummyData' => $data,
                    'parameters' => $parameters,
                    'action' => $action
                ];
            case 'review':
                return [
                    'action' => str_contains($_POST['vpos']['action'], 'webpos') ?
                        '/?p=redirect' :
                        '/?p=result',
                    'CheckKey' => hash(
                        'sha256',
                        $_POST['vpos']['fields']['DealerCode'] . 'MK' .
                        $_POST['vpos']['fields']['Username'] . 'PD' .
                        $_POST['vpos']['fields']['Password']
                    )];
            case 'result':
                $isWebPos = array_key_exists('tx', $_GET);

                if (!$isWebPos) {
                    $client = new Client();

                    $response = $client->request(
                        'POST',
                        env('DIRECT_PAYMENT_FORM_ACTION'),
                        ['json' => [
                            'PaymentDealerAuthentication' => [
                                'DealerCode' => $_POST['DealerCode'],
                                'Username' => $_POST['Username'],
                                'Password' => $_POST['Password'],
                                'CheckKey' => $_POST['CheckKey']
                            ],
                            'PaymentDealerRequest' => [
                                'CardHolderFullName' => $_POST['CardHolderFullName'],
                                'CardNumber' => $_POST['CardNumber'],
                                'ExpMonth' => $_POST['ExpMonth'],
                                'ExpYear' => $_POST['ExpYear'],
                                'CvcNumber' => $_POST['CvcNumber'],
                                'Amount' => $_POST['Amount'],
                                'Currency' => $_POST['Currency'],
                                'ClientIP' => $_POST['ClientIP'],
                                'OtherTrxCode' => $_POST['OtherTrxCode'],
                                'IsPoolPayment' => $_POST['IsPoolPayment'],
                                'IsTokenized' => $_POST['IsTokenized'],
                                'Software' => $_POST['Software'],
                                'IsPreAuth' => $_POST['IsPreAuth']
                            ]
                        ]]);

                    $result = json_decode($response->getBody()->getContents());

                    return [
                        'success' => !is_null($result->Data) && $result->Data->IsSuccessful,
                        'errorMessage' =>
                            array_key_exists(
                                $result->ResultCode,
                                self::ERROR_MESSAGES
                            ) ?
                                self::ERROR_MESSAGES[$result->ResultCode] . ' ' .
                                $result->ResultMessage :
                                $result->ResultMessage
                    ];
                }

                return [
                    'success' =>
                        array_key_exists('tx', $_GET) &&
                        array_key_exists('hashValue', $_POST) &&
                        $this->checkWebPosHash(true),
                    'errorMessage' => $_POST['resultMessage']
                ];
            default:
                return [];
        }
    }

    function checkRedirect()
    {
        if (array_key_exists('p', $_GET) && $_GET['p'] == 'redirect') {
            include_once __DIR__ . '/' . 'redirect.php';
        }
    }

    function load()
    {
        if (
            !$this->isPageExists() or
            (
                isset($_GET['p']) and
                $_GET['p'] === self::PAGE_NAME_REVIEW and
                !isset($_POST['vpos'])
            )
        ) {
            http_response_code(404);

            $this->setPageName(self::PAGE_NAME_NOT_FOUND);
        }

        $pageData = $this->loadPageData();
        include_once $this->getAbsolutePagePath();
    }
}