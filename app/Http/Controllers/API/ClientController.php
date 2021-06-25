<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
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
        
         Client::create($request->all());
        return response()->json('success');
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
    public function find($search)
    {
    // Search the clients table by client last name
    $clients = Client::query()
        ->where('last_name', 'LIKE', "%{$search}%")
        ->get();
    // Return the results
    return response()->json($clients);
     
    }
    
}
