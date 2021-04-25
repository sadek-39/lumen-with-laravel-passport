<?php

namespace App\Http\Controllers;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    //
    public function index(){
        return response()->json("hello");
    }
    public function login(Request $request)
    {
        //return \response()->json("hello");

         $email=$request->input('email');
         $password=$request->input('password');
         if(empty($email) OR empty($password)){
             return response()->json('invalid Parameter');
         }
         else{
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:8000/v1/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('client_secret' => 'XjFHxlQAcQKUPq4LFhzl8QFaWgyHbUhHpvuOsioY',
                                        'grant_type' => 'password',
                                        'client_id' => '2',
                                        'username' => $request->email,
                                        'password' => $request->password),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            return $response;
         }
         
        //  $client=new Client();
        //  try{
        //      return $client->post(\config('service.passport.login_endpoint'),[
        //          "form_params"=>[
        //              "client_secret"=>\config('service.passport.client_secret'),
        //              "grant_type"=>"password",
        //              "client_id"=>\config('service.passport.client_id'),
        //              "username"=>$request->input(email),
        //              "password"=>$request->input(password)
        //          ]
        //      ]);
        //  }catch(BadResponseException $e){
        //      return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        //  }         

    }
    public function create(Request $request)
    {
        $user=User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);

        

        return response()->json($user,201);
    }  

    public function logintoken($email,$password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:8000/v1/oauth/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('client_secret' => 'QUsIhOxem3qWsdVq8rO95kUjKEcHmr4QRMXZ2eow',
                                    'grant_type' => 'password',
                                    'client_id' => '4',
                                    'username' => $email,
                                    'password' => $password),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
        // $response=$client->post(\config('service.passport.login_endpoint'),[
        //     "form_params"=>[
        //         "grant_type"=>"password",
        //         "client_id"=>\config('service.passport.client_id'),
        //         "client_secret"=>\config('service.passport.client_secret'),
        //         "username"=>$request->email,
        //         "password"=>$request->password,
        //     ]
        // ]);
    }
    
}