<?php
/**
 * GetPromotions Api 
 * 
 * PHP version 7
 *
 * @category Api
 * @package  WHMCS
 * @author   Kuroit <hello@kuroit.com>
 * @license  https://portal.hostworld.uk/ License
 * @link     https://portal.hostworld.uk/
 */

if (!defined('ORDER_API_CALL')) {
    printError(['status' =>'error','data' => 'Invalid Operation.']); 
} 
if (isset($_POST['promoCode']) && !empty($_POST['promoCode']) && isset($_POST['productPid']) && !empty($_POST['productPid']) && isset($_POST['cycle']) && !empty($_POST['cycle'])) {
    $param=santizeInput($_POST);

    $args=[
        'action' => 'GetPromotions',
        'code'   => $param['promoCode'],
    ];
    $response=curlCall($args);

    if ($response["status"]=="success" && $response["totalresults"] > 0) {
        $appliesTo=explode(",", $response["promotions"]["promotion"][0]["appliesto"]);
        $validCycles=explode(",", strtolower($response["promotions"]["promotion"][0]["cycles"]));
        $expirationDate=$response["promotions"]["promotion"][0]["expirationdate"];

        if ($expirationDate == "0000-00-00" || strtotime($expirationDate) >= strtotime(date("Y-m-d"))) {
            if (isset($appliesTo) && count($appliesTo) > 0 && in_array($param['productPid'], $appliesTo)) {
                if (isset($validCycles) && ((count($validCycles) > 0  && in_array(strtolower($param["cycle"]), $validCycles)) ||  count($validCycles) == 0 )) {
                    printSuccess(
                        [
                            'status'=>'success',
                            'value'=>$response["promotions"]["promotion"][0]["value"],
                            'type'=>$response["promotions"]["promotion"][0]["type"],
                        ]
                    );
                }
            }
        }
    }
    printError(['status'=>'error','message'=>'invalid promocode']);
}
