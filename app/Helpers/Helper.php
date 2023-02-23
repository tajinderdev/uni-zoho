<?php

namespace App\Helpers;
use App\Models\Api;

class Helper
{
    public static function getToken()
    {
      $url = "https://accounts.zoho.com/oauth/v2/token?refresh_token=".env('ZOHO_REFRESH')."&client_id=".env('ZOHO_CLIENT_ID')."&client_secret=".env('ZOHO_CLIENT_SECRET')."&grant_type=refresh_token";

       // $api = Api::where("type",$type)->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function getUniToken()
    {
      $url = "https://quickshift.unicommerce.com/oauth/token?";
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url.'grant_type=password&client_id=my-trusted-client&username='.env('UNI_USERNAME').'&password='.env('UNI_PASSWORD'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
    }

    public static function getAllSO($token, $fromto)
    {
      $url = 'https://quickshift.unicommerce.com/services/rest/v1/oms/saleOrder/search';
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode($fromto),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: bearer '.$token,
          'Cookie: unicommerce=app1'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
    }

    public static function getSingleSO($token, $code)
    {
      $url = 'https://quickshift.unicommerce.com/services/rest/v1/oms/saleorder/get';
      $curl = curl_init();
      
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "code": '.$code.'
      }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: bearer '.$token,
          'Cookie: unicommerce=app1'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
    }

    public static function insertSalesOrders($token, $data)
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Sales_Orders?scope=ZohoCRM.modules.Sales%20Orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Zoho-oauthtoken '.$token,
          'Content-Type: application/json',
          'Cookie: 1a99390653=845f12d8216a8bbaaf49e05a6ac6a5c2; _zcsr_tmp=38b9cd26-1144-41e8-a21d-f61bde6885f7; crmcsr=38b9cd26-1144-41e8-a21d-f61bde6885f7'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;
    } 
}