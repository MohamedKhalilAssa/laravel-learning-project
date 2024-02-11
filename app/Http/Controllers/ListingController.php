<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // constructor
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    //all listings
    public function index(){
        return view('listings.index',[
            "Listings" => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ]);
    }

    // single listing
    public function show(Listing $Listing){
        return view('listings.show',[
            "Listing" => $Listing
        ]);
    }
    //creating
    public function create(){
        return view('listings.create');
    }
    // storing new job
    public function store(Request $request){

        $formElements = $request->validate([
            "title" => 'required',
            "email" => ['required','email'],
            "location" => 'required',
            "company" => 'required',
            "description" => 'required',
            "tags" => 'required',
            'image' => 'image|mimes:jpeg,png,pdf|max:2048',
            "website" => 'required'
        ]);

        if($request->hasFile('image')){
            $formElements['image'] = $request->file('image')->store('logos','public');
            $formElements['image'] = 'storage/' . $formElements['image'];
        }

        $formElements['user_id'] = auth()->id();

        Listing::create($formElements);

        return redirect('/')->with('success','Job created successfully');
    }

    // EDIT FUNCTION
    public function edit(Listing $Listing){
        return view('listings.edit',[
            "Listing" => $Listing
        ]);
    }
    public function update(Request $request, Listing $Listing){

        if($Listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        $formElements = $request->validate([
            "title" => 'string',
            "email" => 'email',
            "location" => 'string',
            "company" => 'string',
            "description"=>['string','min:0'],
            "tags" => 'string',
            "website" => 'string'
        ]);

        if($request->hasFile('image')){
            $formElements['image'] = $request->file('image')->store('logos','public');
            $formElements['image'] = 'storage/' . $formElements['image'];
        }


        $Listing->update($formElements);

        return redirect('/')->with('success','Updated successfully');
    }
    public function destroy( Listing $Listing){

        if($Listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }

        $Listing->delete();

        return redirect('/')->with('success','Deleted successfully');
    }
// manage
    public function manage(){
        return view('listings.manage',[
            'Listings' => auth()->user()->listings()->get()
        ]);
    }
}
