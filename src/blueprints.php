<?php

namespace Vpos;

return [
    'DirectPayment' => [
        'action' => '',
        'parameters' => [
            'PaymentDealerAuthentication' => [
                ['name' => 'DealerCode', 'optional' => false],
                ['name' => 'Username', 'optional' => false],
                ['name' => 'Password', 'optional' => false],
                ['name' => 'CheckKey', 'optional' => false],
            ],
            'PaymentDealerRequest' => [
                ['name' => 'CardHolderFullName', 'optional' => false],
                ['name' => 'CardNumber', 'optional' => false],
                ['name' => 'ExpMonth', 'optional' => false],
                ['name' => 'ExpYear', 'optional' => false],
                ['name' => 'CvcNumber', 'optional' => false],
                ['name' => 'CardToken', 'optional' => true],
                ['name' => 'Amount', 'optional' => false],
                ['name' => 'Currency', 'optional' => false],
                ['name' => 'InstallmentNumber', 'optional' => true],
                ['name' => 'ClientIP', 'optional' => false],
                ['name' => 'OtherTrxCode', 'optional' => false],
                ['name' => 'SubMerchantName', 'optional' => true],
                ['name' => 'ClientWebPosTypeId', 'optional' => false],
                ['name' => 'IsThreeD', 'optional' => false],
                ['name' => 'IsPoolPayment', 'optional' => false],
                ['name' => 'IsPreAuth', 'optional' => false],
                ['name' => 'IsTokenized', 'optional' => false],
                ['name' => 'RedirectUrl', 'optional' => false],
                ['name' => 'Language', 'optional' => true],
                ['name' => 'Description', 'optional' => true],
                ['name' => 'ReturnHash', 'optional' => true],
                ['name' => 'RedirectType', 'optional' => true],
                [
                    'name' => 'BuyerInformation',
                    'parameters' => [
                        'BuyerFullName',
                        'BuyerEmail',
                        'BuyerGsmNumber',
                        'BuyerAddress'
                    ],
                    'optional' => true
                ],
                [
                    'name' => 'BasketProduct',
                    'parameters' => [
                        'ProductId',
                        'ProductCode',
                        'UnitPrice',
                        'Quantity'
                    ],
                    'optional' => true
                ],
                [
                    'name' => 'CustomerInformation',
                    'parameters' => [
                        'DealerCustomerId',
                        'CustomerCode',
                        'LastName',
                        'Gender',
                        'BirthDate',
                        'GsmNumber',
                        'Email',
                        'Address',
                        'CardName'
                    ],
                    'optional' => true
                ]
            ]
        ]
    ],
    'WebPos' => [
        'action' => '',
        'parameters' => [
            'PaymentDealerAuthentication' => [
                ['name' => 'DealerCode', 'optional' => false],
                ['name' => 'Username', 'optional' => false],
                ['name' => 'Password', 'optional' => false],
                ['name' => 'CheckKey', 'optional' => false],
            ],
            'WebPosRequest' => [
                ['name' => 'Amount', 'optional' => false],
                ['name' => 'Currency', 'optional' => false],
                ['name' => 'OtherTrxCode', 'optional' => false],
                ['name' => 'ClientWebPosTypeId', 'optional' => false],
                ['name' => 'IsThreeD', 'optional' => false],
                ['name' => 'IsPoolPayment', 'optional' => false],
                ['name' => 'IsPreAuth', 'optional' => false],
                ['name' => 'IsTokenized', 'optional' => false],
                ['name' => 'RedirectUrl', 'optional' => false],
                ['name' => 'InstallmentNumber', 'optional' => true],
                ['name' => 'Language', 'optional' => true],
                ['name' => 'SubMerchantName', 'optional' => true],
                ['name' => 'Description', 'optional' => true],
                ['name' => 'ReturnHash', 'optional' => true],
                ['name' => 'RedirectType', 'optional' => true],
                [
                    'name' => 'BuyerInformation',
                    'parameters' => [
                        'BuyerFullName',
                        'BuyerEmail',
                        'BuyerGsmNumber',
                        'BuyerAddress'
                    ],
                    'optional' => true
                ],
                [
                    'name' => 'BasketProduct',
                    'parameters' => [
                        'ProductId',
                        'ProductCode',
                        'UnitPrice',
                        'Quantity'
                    ],
                    'optional' => true
                ],
                [
                    'name' => 'CustomerInformation',
                    'parameters' => [
                        'DealerCustomerId',
                        'CustomerCode',
                        'LastName',
                        'Gender',
                        'BirthDate',
                        'GsmNumber',
                        'Email',
                        'Address',
                        'CardName'
                    ],
                    'optional' => true
                ]
            ]
        ]
    ],
];