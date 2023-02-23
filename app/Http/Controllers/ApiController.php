<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller as Controller;

use Storage;
use Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\Api;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

set_time_limit(0);

class ApiController extends Controller
{
    public function GetToken()
    {
        $expired_at  = Token::where('id',1)->value('expired_at');
        if($expired_at < Carbon::now()) {
            $resp = json_decode(Helper::getToken());
            Token::where('id',1)->update([
                    'access_token' => $resp->access_token,
                    'expired_at'=> Carbon::now()->addSeconds($resp->expires_in)
            ]);
            return $resp->access_token;
        } else {
            return Token::where('id',1)->value('access_token');
        }
    }

    public function GetUniToken()
    {
        $expired_at  = Token::where('id',2)->value('expired_at');
        if($expired_at < Carbon::now()) {
            $resp = json_decode(Helper::getUniToken());
            Token::where('id', 2)->update([
                    'access_token' => $resp->access_token,
                    'refresh_token' => $resp->refresh_token,
                    'expired_at'=> Carbon::now()->addSeconds($resp->expires_in)
            ]);
            return $resp->access_token;
        } else {
            $resp = Token::where('id',2)->first();
            return $resp->access_token;
        }
    }

    public function getAllSalesOrder()
    {
        $token = $this->GetUniToken();
        $from = "2023-02-05T00:00:00.812Z";
        $to = "2023-02-26T00:00:00.812Z";
        $fromto = [
            "fromDate" => $from,
            "toDate" => $to,
            "dateType" => "CREATED"
        ];
        $resp = json_decode(Helper::getAllSO($token, $fromto));
        return $resp;
    }

    public function getSingleOrder($token, $code)
    {
        $resp = json_decode(Helper::getSingleSO($token, $code));
        return $resp;
    }
    public function insertSO($token, $rawData){
        $json = '{
            "Owner": {
                "name": "Neeraj Katare",
                "id": "2582603000000120009",
                "email": "neeraj@drstore.in"
            },
            "Company": "Unicommerce",
            "Subject": "Uni To Zoho Sales Order",
            "Status": "Created",
            "ICAP_Order_No": "11111",
            "Sales_Order_Type": ["Welcome Kit - Basic"],
            "Member_Name": "Tajinder",
            "Member_Code": "1222",
            "Member_Email_ID": "tajindr.developer@gmail.com",
            "Member_Phone_NO": "7009705039",
            "Product_Details": [
                {
                    "product": {
                        "name":"Abbott FreestyleCGM Libre Patches (Sensors) (ABT_CGM_LIB_PCH)",
                        "id":"2582603000011761118"
                        },
                    "quantity": 1,
                    "unit_price": "4300"
                }
            ],
            "Email": "tajinder1243@gmail.com",
            "$currency_symbol": "₹",
            "Customer_Name": null,
            "$field_states": null,
            "Last_Activity_Time": null,
            "Industry": null,
            "$state": "save",
            "$converted": false,
            "$process_flow": false,
            "Exchange_Rate": 1,
            "Currency": "INR",
            "id": "2582603000014282001",
            "$approved": true,
            "$approval": {
                "delegate": false,
                "approve": false,
                "reject": false,
                "resubmit": false
            },

            "Created_Time": "2023-01-06T23:38:19+05:30",
            "$editable": true,

            "Created_By": {
                "name": "Neeraj Katare",
                "id": "2582603000000120009",
                "email": "neeraj@drstore.in"
            },

            "First_Name": "tajinder",
            "Full_Name": "tajinder singh",
            "Record_Image": null,
            "Modified_By": {
                "name": "Neeraj Katare",
                "id": "2582603000000120009",
                "email": "neeraj@drstore.in"
            },
            "$review": null,
            "Phone": null,
            "Email_Opt_Out": false,
            "Designation": null,
            "Modified_Time": "2023-01-06T23:38:19+05:30",
            "No_of_Beds": "123",
            "$converted_detail": {},
            "Unsubscribed_Time": null,
            "Mobile": null,
            "$orchestration": false,
            "Type": null,
            "s": null,
            "Last_Name": "Singh",
            "Layout": {
                "name": "Twin Health SO",
                "id": "2582603000012107001"
            },
            "$in_merge": false,
            "Lead_Source": "Facebook",
            "Tag": [],
            "Fax": null,
            "$approval_state": "approved",
            "$pathfinder": null,
            "Last_Enriched_Time__s": null
        }';
        $array = json_decode($json);
        // echo "<pre>";
        // print_r($array);
        // die;
        // foreach($rawData as $resData)
        // {}
        // $array = $rawData['saleOrderDTO'];
        // echo "<pre>";print_r($rawData);
        // die;
        $data = '{
            "data": [
                {
                    "Owner": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
                    "Company": "apisss",
                    "Subject": "tester",
                    "Status": "Created",
                    "ICAP_Order_No": "11111",
                    "Sales_Order_Type": ["Welcome Kit - Basic"],
                    "Member_Name": "Tajinder",
                    "Member_Code": "1222",
                    "Member_Email_ID": "tajindr.developer@gmail.com",
                    "Member_Phone_NO": "7009705039",
                    "Product_Details": [
                        {
                            "product": {
                                "name":"Abbott FreestyleCGM Libre Patches (Sensors) (ABT_CGM_LIB_PCH)",
                                "id":"2582603000011761118"
                                },
                            "quantity": 1,
                            "unit_price": "4300"
                        }
                    ],
                    "Email": "tajinder1243@gmail.com",
                    "$currency_symbol": "₹",
                    "Customer_Name": null,
                    "$field_states": null,
                    "Last_Activity_Time": null,
                    "Industry": null,
                    "$state": "save",
                    "$converted": false,
                    "$process_flow": false,
                    "Exchange_Rate": 1,
                    "Currency": "INR",
                    "id": "2582603000014282001",
                    "$approved": true,
                    "$approval": {
                        "delegate": false,
                        "approve": false,
                        "reject": false,
                        "resubmit": false
                    },
  
                    "Created_Time": "2023-01-06T23:38:19+05:30",
                    "$editable": true,
  
                    "Created_By": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
  
                    "First_Name": "tajinder",
                    "Full_Name": "tajinder singh",
                    "Record_Image": null,
                    "Modified_By": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
                    "$review": null,
                    "Phone": null,
                    "Email_Opt_Out": false,
                    "Designation": null,
                    "Modified_Time": "2023-01-06T23:38:19+05:30",
                    "No_of_Beds": "123",
                    "$converted_detail": {},
                    "Unsubscribed_Time": null,
                    "Mobile": null,
                    "$orchestration": false,
                    "Type": null,
                    "s": null,
                    "Last_Name": "Singh",
                    "Layout": {
                        "name": "Twin Health SO",
                        "id": "2582603000012107001"
                    },
                    "$in_merge": false,
                    "Lead_Source": "Facebook",
                    "Tag": [],
                    "Fax": null,
                    "$approval_state": "approved",
                    "$pathfinder": null,
                    "Last_Enriched_Time__s": null
                },
                {
                    "Owner": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
                    "Company": "Test2",
                    "Subject": "test2",
                    "Status": "Created",
                    "ICAP_Order_No": "22222",
                    "Sales_Order_Type": ["Welcome Kit - Basic"],
                    "Member_Name": "Tajinder2",
                    "Member_Code": "33333",
                    "Member_Email_ID": "tajindr.developer@gmail.com",
                    "Member_Phone_NO": "7009705039",
                    "Product_Details": [
                        {
                            "product": {
                                "name":"Abbott FreestyleCGM Libre Patches (Sensors) (ABT_CGM_LIB_PCH)",
                                "id":"2582603000011761118"
                                },
                            "quantity": 1,
                            "unit_price": "4300"
                        }
                    ],
                    "Email": "tajinder2222@gmail.com",
                    "$currency_symbol": "₹",
                    "Customer_Name": null,
                    "$field_states": null,
                    "Last_Activity_Time": null,
                    "Industry": null,
                    "$state": "save",
                    "$converted": false,
                    "$process_flow": false,
                    "Exchange_Rate": 1,
                    "Currency": "INR",
                    "id": "2582603000014282001",
                    "$approved": true,
                    "$approval": {
                        "delegate": false,
                        "approve": false,
                        "reject": false,
                        "resubmit": false
                    },
  
                    "Created_Time": "2023-01-06T23:38:19+05:30",
                    "$editable": true,
  
                    "Created_By": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
  
                    "First_Name": "tajinder",
                    "Full_Name": "tajinder singh",
                    "Record_Image": null,
                    "Modified_By": {
                        "name": "Neeraj Katare",
                        "id": "2582603000000120009",
                        "email": "neeraj@drstore.in"
                    },
                    "$review": null,
                    "Phone": null,
                    "Email_Opt_Out": false,
                    "Designation": null,
                    "Modified_Time": "2023-01-06T23:38:19+05:30",
                    "No_of_Beds": "123",
                    "$converted_detail": {},
                    "Unsubscribed_Time": null,
                    "Mobile": null,
                    "$orchestration": false,
                    "Type": null,
                    "s": null,
                    "Last_Name": "Singh",
                    "Layout": {
                        "name": "Twin Health SO",
                        "id": "2582603000012107001"
                    },
                    "$in_merge": false,
                    "Lead_Source": "Facebook",
                    "Tag": [],
                    "Fax": null,
                    "$approval_state": "approved",
                    "$pathfinder": null,
                    "Last_Enriched_Time__s": null
                }
            ]
        }';
        // $resp = json_decode(Helper::insertSalesOrder($rawData));
        // return $resp;
        // echo "<pre>";print_r($rawData);
        // die;
        $resp = json_decode(Helper::insertSalesOrders($token, $data));
        return $resp;
    }

    public function zoho(Request $request)
    {
        $token = $this->GetToken();
        $uniToken = $this->GetUniToken();
        $salesOrders = $this->getAllSalesOrder();

        $ordercodes = [];
        foreach($salesOrders->elements as $order)
        {
            // $ordercodes[] = $this->getSingleOrder($uniToken, $order->code);
            $ordercodes[] = json_decode(Helper::getSingleSO($uniToken, $order->code));
            // $this->insertSO($token, $ordercodes);
            // echo "<pre>";print_r($ordercodes);
            if(count($ordercodes) == 4)
            {
                break;
            }
        }

        echo "<pre>";print_r($ordercodes);
        die;

        $addSalesOrders = $this->insertSO($token, $ordercodes);

        // return json_decode($addSalesOrders);

        echo "<pre>";print_r($addSalesOrders);
        die;
    }

}
