<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\users;
use Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

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
    public function createusers(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [ // <---
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
        //    dd($validator);
            if ($validator->fails())
            {
                return redirect('create-users')->with('errors',$validator->errors())->withInput();
                // The given data did not pass validation.
            }
            $users = new users();
            $users->first_name = $request->first_name;
            $users->last_name = $request->last_name;
            $users->save();
            return redirect('create-users')->with('message','Users Added Successfully');
        }
        else{
            return view('users');
        }
    }
    public function sendemail(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [ // <---
                'email_id' => 'required',
                'message_data' => 'required',
            ]);
        //    dd($validator);
            if ($validator->fails())
            {
                return redirect('send-email')->with('errors',$validator->errors())->withInput();
                // The given data did not pass validation.
            }
            $data = array('message_data'=>$request->message_data);
            $mail_from = $request->email_id;
            Mail::send('mail/inquiry', $data, function($message) use ($request,$mail_from) {
                $message->to($mail_from)->subject
                   ('Inquiry');
                $message->from('asifkaushar@gmail.com','Inquiry');
             });
             return redirect('send-email')->with('message','Email has been sent to that person successfully');
        }
        else{
            return view('send_email');
        }
    }
    public function public_ip(Request $request)
    {
        $ip = $request->ip();
      
        $response = new \Illuminate\Http\Response('Hello, World!');;
        $response->withCookie(Cookie::make('ip', $ip));
       
        $value = $request->cookie('ip');
        dd($value);

    }
}
