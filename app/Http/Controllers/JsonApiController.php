<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonApiController extends Controller
{
    public function index(Request $request)
    {
        
       

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://opencontext.org/query/Asia/Turkey/Kenan+Tepe.json',
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
// echo $response;
$response_data = json_decode($response, true);
// dd($response_data);
// dd($response_data['features'][0]['when']['id']);
$csv_header = '';
$csv_header .= 'id'.',';
$csv_header .= 'href'.',';
$csv_header .= 'label'.',';
$csv_header .= 'feature-type'.',';
// $csv_header .= 'count'.',';
$csv_header .= 'early bce/ce'.',';
$csv_header .= 'late bce/ce'.',';
$csv_header .= "\n";
$csv_row ='';

for($i=0;$i< count($response_data['features']);$i++)
{
    if(isset($response_data['features'][$i]['properties']))
    {
        for($j=0;$j< count($response_data['features'][$i]['properties']);$j++)
        {
            $csv_row .= '"' . $response_data['features'][$i]['properties']['id'] . '",';
            $csv_row .= '"' . $response_data['features'][$i]['properties']['href'] . '",';
            $csv_row .= '"' . $response_data['features'][$i]['properties']['label'] . '",';
            $csv_row .= '"' . $response_data['features'][$i]['properties']['feature-type'] . '",';
            // $csv_row .= '"' . $response_data['features'][$i]['properties']['count'] . '",';
            $csv_row .= '"' . $response_data['features'][$i]['properties']['early bce/ce'] . '",';
            $csv_row .= '"' . $response_data['features'][$i]['properties']['late bce/ce'] . '",';
   
             $csv_row .= "\n";
            // echo $response_data['features'][$i]['properties']['id'];
            // echo "<br>";
        }
    }
   
    // echo $response_data['features'][$i]['id'];
    // echo "<br>";
}
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=data.csv');
echo $csv_header . $csv_row;
exit;
// dd($response_data['features'][0]);
// dd(json_decode($response, true));
// dd($response);

    }
    public function duplicatejsonapi(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://opencontext.org/query/Asia/Turkey/Kenan+Tepe.json',
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
        // echo $response;
        $response_data = json_decode($response, true);
        $array_temp = array();
        $csv_header = '';
$csv_header .= 'id'.',';
$csv_header .= 'href'.',';
$csv_header .= 'label'.',';
$csv_header .= 'feature-type'.',';
// $csv_header .= 'count'.',';
$csv_header .= 'early bce/ce'.',';
$csv_header .= 'late bce/ce'.',';
$csv_header .= "\n";
$csv_row ='';
        for($i=0;$i< count($response_data['features']);$i++)
        {
            if(isset($response_data['features'][$i]['properties']))
            {
                for($j=0;$j< count($response_data['features'][$i]['properties']);$j++)
                {
                    if (!in_array($response_data['features'][$i]['properties']['id'], $array_temp))
                    {

                        $array_temp[] = $response_data['features'][$i]['properties']['id'];
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['id'] . '",';
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['href'] . '",';
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['label'] . '",';
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['feature-type'] . '",';
                        // $csv_row .= '"' . $response_data['features'][$i]['properties']['count'] . '",';
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['early bce/ce'] . '",';
                        $csv_row .= '"' . $response_data['features'][$i]['properties']['late bce/ce'] . '",';
            
                        $csv_row .= "\n";
                    }
                    else
                    {
                        // echo 'duplicate = ' . $val . '<br />';
                    }
                }
            }
        }
        header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=data.csv');
echo $csv_header . $csv_row;
exit;
    }
}
