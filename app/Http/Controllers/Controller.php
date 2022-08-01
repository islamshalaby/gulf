<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use SoapClient;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createClient() {
        try {
            $data['soapClient'] = new SoapClient(env('POSTA_URL'));
            
            $data['ci'] = [
                'CodeStation' => env('POSTA_CODESTATION'),
                'Password' => env('POSTA_PASSWORD'),
                'ShipperAccount' => env('POSTA_SHIPPER_ACCOUNT'),
                'UserName' => env('POSTA_USERNAME'),
            ];
            
            return $data;
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // create shipment
    public function createShipment(
        $data,
        $shipmentCost,
        $receiverCity='NA',
        $height=0,
        $length=0,
        $width=0,
        $senderCity='NA',
        $currency='KWD',
        $shippmentService='SRV13',
        $shippmentType='SHPT1',
        $insured='N',
        $note='',
        $prohibited='N',
        $senderArea='NA',
        $senderPinCode='00965',
        $senderProvince='NA',
        $senderRemark='',
        $receiverArea='NA',
        $receiverCivilId='',
        $codeSector='NA',
        $receiverDesignation='NA',
        $receiverPinCode='NA',
        $receiverProvince='NA',
        $mps='NA',
        $itemHeight=0,
        $needPickUp='N',
        $needRoundTrip='N',
        $parentWayBill='',
        $payMode='',
        $wayBill=''
        ) {
        try {
            $data_shiping['soapClient'] = new SoapClient(env('POSTA_URL'));
            
            $data_shiping['SHIPINFO'] = [
                'CashOnDelivery' => 0,
                'CashOnDeliveryCurrency' => '',
                'ClientInfo' => [
                    'CodeStation' => env('POSTA_CODESTATION'),
                    'Password' => env('POSTA_PASSWORD'),
                    'ShipperAccount' => env('POSTA_SHIPPER_ACCOUNT'),
                    'UserName' => env('POSTA_USERNAME'),
                ],
                'CodeCurrency' => $currency, // currency paid (required)
                'CodeService' => $shippmentService, // like airway - air default (required)
                'CodeShippmentType' => $shippmentType, // doc default (required)
                'ConnoteContact' => [
                    'Email1' => $data['sender_email'], // sender email
                    'Email2' => $data['receiver_email'], // receiver email
                    'TelHome' => $data['receiver_phone'], // receiver phone (required)
                    'TelMobile' => $data['receiver_mobile'], // receiver mobile (required)
                    'WhatsAppNumber' => $data['receiver_whats'], // receiver whatsapp
                ],
                'ConnoteDescription' => $data['shipment_description'], // shipment description (required)
                'ConnoteInsured' => $insured, // insured shipment or not
                'ConnoteNotes' => [
                    'Note1' => $note // empty default
                ],
                'ConnotePerformaInvoice' => [
                    'CONNOTEPERMINV' => [
                        'CodeHS' => '8708.99.00', // from excel sheet
                        'CodePackageType' => 'PCKT2', // package type - box
                        'Description' => $data['product_description'], // product description (required)
                        'OrginCountry' => $data['product_origin_country'], // product origin country (required)
                        'Quantity' => $data['quantity'], // quantity (required)
                        'RateUnit' => $data['unit_price'] // unit price (required)
                    ]
                ],
                'ConnotePieces' => $data['packages_number'], // packages number (required)
                'ConnoteProhibited' => $prohibited, // is shippment prohibited ? (required)
                'ConnoteRef' => [
                    'Reference1' => $data['order_number'], // order number
                    'Reference2' => $data['receiver_id'], // receiver id
                ],
                'Consignee' => [
                    'Company' => $data['receiver_name'], // receiver name (required)
                    'FromAddress' => $data['sender_address'], // sender address (required)
                    'FromArea' => $senderArea, // sender area - NA default (required)
                    'FromCity' => $senderCity, // sender city - NA default - from excel sheet (required)
                    'FromCodeCountry' => $data['sender_country'], // sender country - from excel sheet (required)
                    'FromMobile' => $data['sender_mobile'], // sender mobile (required)
                    'FromName' => $data['sender_name'], // sender name (required)
                    'FromPinCode' => $senderPinCode, // sender pin code - 00965
                    'FromProvince' => $senderProvince, // sender province - NA default (required)
                    'FromTelphone' => $data['sender_phone'], // sender phone (required)
                    'Remarks' => $senderRemark, // sender remark - empty default
                    'ToAddress' => $data['receiver_address'], // receiver address (required)
                    'ToArea' => $receiverArea, // receiver area - NA default (required)
                    'ToCity' => $receiverCity, // receiver city - NA default - from excel sheet (required)
                    'ToCivilID' => $receiverCivilId, // receiver civil id - empty default
                    'ToCodeCountry' => $data['receiver_country'], // receiver country - from excel sheet (required)
                    'ToCodeSector' => $codeSector, // deprecated - NA default
                    'ToDesignation' => $receiverDesignation, // NA default
                    'ToMobile' => $data['receiver_mobile'], // receiver mobile (required)
                    'ToName' => $data['receiver_name'], // receiver name (required)
                    'ToPinCode' => $receiverPinCode, // receiver pin code - NA default
                    'ToProvince' => $receiverProvince, // receiver province - NA default (required)
                    'ToTelPhone' => $data['receiver_phone'], // receiver phone (required)
                ],
                'CostShipment' => $shipmentCost, // shipment cost - including shipping charges (required)
                'IsMPS' => $mps, // N default
                'ItemDetails' => [
                    'ITEMDETAILS' => [
                        'ConnoteHeight' => $height, // height - 0 default
                        'ConnoteLength' => $length, // length - 0 default
                        'ConnoteWeight' => $data['weight'], // weight (required)
                        'ConnoteWidth' => $width, // width - 0 default
                        'ScaleWeight' => $itemHeight, // item height - 0 default
                    ]
                ],
                'NeedPickUp' => $needPickUp, // N default
                'NeedRoundTrip' => $needRoundTrip, // N default
                'ParentWayBill' => $parentWayBill, // empty default
                'PayMode' => $payMode, // empty default
                'WayBill' => $wayBill // empty default
            ];

            $res = $data_shiping['soapClient']->__SoapCall('Shipment_Creation', [$data_shiping]);
            
            return $res;
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    // cancel shipment
    public function cancelShipment($airwayBillNumber, $reason) {
        try {
            $data['soapClient'] = new SoapClient(env('POSTA_URL'));
            
            $data['CLIENTINFO'] = [
                'CodeStation' => env('POSTA_CODESTATION'),
                'Password' => env('POSTA_PASSWORD'),
                'ShipperAccount' => env('POSTA_SHIPPER_ACCOUNT'),
                'UserName' => env('POSTA_USERNAME'),
            ];

            $data['VOID'] = [
                'Connote' => $airwayBillNumber,
                'Reason' => $reason
            ];
            
            $res = $data['soapClient']->__SoapCall('ShipmentVoid', [$data]);
            return $res;
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
