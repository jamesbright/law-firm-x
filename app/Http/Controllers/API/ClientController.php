<?php
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
class ClientController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all()->toArray();
        return array_reverse($clients);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation rules
        $rules = [ 
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:clients',
        'primary_counsel' => 'required|string',
        'case_details' => 'required|string',
        'dob' => 'required|date',
        'profile_image' => 'image'
        ];

        $response = array('message' => '', 'success'=>false);

$validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        //return error messages
        $response['message'] = $validator->messages();
    }else{
//process the request

//if the client uploaded a profile image then process it
   if($request->hasFile('profile_image')){
            //get filename with extension
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $filename =  preg_replace('/[^a-zA-Z]+/', '', $filename);
            //get just ext
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            //filename to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('profile_image')->storeAs('public/profile_images',$filenameToStore);
        }else{
            $filenameToStore = '';
        }
//create a new client
    $client = new Client;
    $client ->first_name = $request->first_name;
    $client ->last_name = $request->last_name;
    $client ->email = $request->email;
    $client ->primary_counsel = $request->primary_counsel;
    $client ->case_details = $request->case_details;
    $client ->dob = $request->dob;
    $client ->profile_image = $filenameToStore;
    $client->save();
       $response['success']  = true;

//send welcome mail
  $details = [
        'title' => 'Welcome to Law Firm X',
        'body' => 'Thanks for joining us.'
    ];
   
Mail::to($client->email)->send(new TestMail($details));
   
    //dd("Email is Sent.");
}
return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $client = Client::find($id);
        return response()->json($client);
    }

 /**
     * search for a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
    // Search the clients table by client last name
    $clients = Client::query()
        ->where('last_name', 'LIKE', "%{$search}%")
        ->get();
    // Return the results
    return response()->json($clients);
     
    }
    
}
