<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\TransactionCreated;

use Mail;

use App\Transaction;

class PagesController extends Controller
{
    
    public function index(){

    	return view('pages.index');
    }


    public function redirectUser(){

        return view('pages.pay');

    }

    public function store(Request $request){

    	$request->validate([

    		'firstName'   => 'required',

    		'lastName'    => 'required',

    		'phoneNumber' => 'required|max:15',

    		'email'       => 'required|email',

    		'currency'    => 'required',

    		'amount'      => 'required|numeric'

    	]);


   

  		$useramount    = $request->amount;

  		$currency      = $request->currency;

  		$useremail     = $request->email;

  		$total_amount  = 0;
        
      $pay_amount    = 0;

  		

  			if ($currency == 'USD') {
  				
  				$total_amount = intval($useramount) * 1;

  			} else if($currency == 'KES'){

  				$total_amount = intval($useramount) * 4.3;

  			} elseif ($currency == 'GHS') {
  				
  				$total_amount = intval($useramount) * 6.2;

  			} elseif ($currency == 'EUR') {
  				
  				$total_amount = intval($useramount) * 0.85 ;

  			}elseif($currency == 'GBP'){

  				$total_amount = intval($useramount) * 0.74;

  			}else{

  				$total_amount = intval($useramount) * 486 ;
                
                 $pay_amount = $total_amount * 100;
                
  			}

  		
        if ($currency === 'NGN') {
            
           
            
           if($pay_amount >=  25000000){
            
            
        $collected_data  = [

		   "tx_ref"          => time(),
		   "amount"          => $total_amount,
		   "currency"        => $currency,
		   "redirect_url"    => "http://127.0.0.1:8000/",
		   "payment_options" => "card",
		   "meta" => [
		      "price"=> $total_amount
		   ],
		   "customer" => [
		      "email"=>  $useremail
		   ],
		   "customizations"=> [
		      "title"=> "Pied Piper Payments",
		      "description"=> "Middleout isn't free. Pay the price",
		      "logo"=> "https://assets.piedpiper.com/logo.png"
		   ]
		];


		
		//send Data to flutterwave Endpoints::-->


		$curl = curl_init();

		curl_setopt_array($curl, array(
 	    CURLOPT_URL            => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT       =>  0,
        CURLOPT_MAXREDIRS      => 10,
  		CURLOPT_CUSTOMREQUEST  => "POST",
  		CURLOPT_POSTFIELDS     => json_encode($collected_data),
	  		CURLOPT_HTTPHEADER => array(
	  		"Authorization: FLWSECK-0bb5bcb9f43c87d58aa78ec3f420c00e-X",
	    	"content-type: application/json",
	    	"cache-control: no-cache"	    	
	  	),
		));


		$response = curl_exec($curl);


		//Decode the JSON request

		$result = json_decode($response);


		//Check if the the result status is successful -->

		if (!empty($result)) {
			
			if ($result->status  == "success") {
			
				$link  = $result->data->link;

				return redirect()->to($link);

			}else{

				echo "We cannot process your request!";
			}


		}else{

			echo"Check your Internet Connection Please seems you are not connected!";
		}

		
            
            
            }
            $curl = curl_init();

            $email =  $useremail;

            $amount = $total_amount*100;  //the amount in kobo. This value is actually NGN 300

            // url to go to after payment
            $callback_url = 'myapp.com/pay/callback.php';  

            curl_setopt_array($curl, array(

              CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode([
                'amount'=>$total_amount*100,
                'email'=>$email,
                'callback_url' => $callback_url
              ]),
              CURLOPT_HTTPHEADER => [
                "authorization: Bearer sk_live_2511551d90981e01962f0924d721dc0ee5e61d46", //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
              ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if($err){
              // there was an error contacting the Paystack API
              die('Curl returned error: ' . $err);
            }

            $tranx = json_decode($response, true);

            if(!$tranx['status']){
              // there was an error from the API
              print_r('API returned error: ' . $tranx['message']);
            }

            // comment out this line if you want to redirect the user to the payment page
            print_r($tranx);
            // redirect to page so User can pay
            // uncomment this line to allow the user redirect to the payment page
            header('Location: ' . $tranx['data']['authorization_url']);



            //Callback URL

            $curl = curl_init();

            $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
            if(!$reference){
              die('No reference supplied');
            }

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_live_2511551d90981e01962f0924d721dc0ee5e61d46",
                "cache-control: no-cache"
              ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if($err){
                // there was an error contacting the Paystack API
              die('Curl returned error: ' . $err);

            }

            $tranx = json_decode($response);

            if(!$tranx->status){
              // there was an error from the API
              die('API returned error: ' . $tranx->message);
            }

            if('success' == $tranx->data->status){
              // transaction was successful...
              // please check other things like whether you already gave value for this ref
              // if the email matches the customer who owns the product etc
              // Give value
              echo "<h2>Thank you for making a purchase. Your file has bee sent your email.</h2>";
            }

        }
  		

		$collected_data  = [

		   "tx_ref"          => time(),
		   "amount"          => $total_amount,
		   "currency"        => $currency,
		   "redirect_url"    => "http://127.0.0.1:8000/",
		   "payment_options" => "card",
		   "meta" => [
		      "price"=> $total_amount
		   ],
		   "customer" => [
		      "email"=>  $useremail
		   ],
		   "customizations"=> [
		      "title"=> "Pied Piper Payments",
		      "description"=> "Middleout isn't free. Pay the price",
		      "logo"=> "https://assets.piedpiper.com/logo.png"
		   ]
		];


		
		//send Data to flutterwave Endpoints::-->


		$curl = curl_init();

		curl_setopt_array($curl, array(
 	    CURLOPT_URL            => "https://api.flutterwave.com/v3/payments",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT       =>  0,
        CURLOPT_MAXREDIRS      => 10,
  		CURLOPT_CUSTOMREQUEST  => "POST",
  		CURLOPT_POSTFIELDS     => json_encode($collected_data),
	  		CURLOPT_HTTPHEADER => array(
	  		"Authorization: FLWSECK-0bb5bcb9f43c87d58aa78ec3f420c00e-X",
	    	"content-type: application/json",
	    	"cache-control: no-cache"	    	
	  	),
		));


		$response = curl_exec($curl);


		//Decode the JSON request

		$result = json_decode($response);


		//Check if the the result status is successful -->

		if (!empty($result)) {
			
			if ($result->status  == "success") {
			
				$link  = $result->data->link;

				return redirect()->to($link);

			}else{

				echo "We cannot process your request!";
			}


		}else{

			echo"Check your Internet Connection Please seems you are not connected!";
		}

		



    }
} 
