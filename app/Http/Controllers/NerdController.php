<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Nerds;

class NerdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // get all the nerds
        $nerds = Nerds::all();

        // load the view and pass the nerds
        return view('nerds.index',array('nerds'=> $nerds));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // load the create form (app/views/nerds/create.blade.php)
      return view('nerds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // validate
      // read more on validation at http://laravel.com/docs/validation
      $rules = array(
          'name'       => 'required',
          'email'      => 'required|email',
          'nerd_level' => 'required|numeric'
      );
      $validator = Validator::make(Input::all(), $rules);

      // process the login
      if ($validator->fails()) {
          return Redirect::to('nerds/create')
              ->withErrors($validator)
              ->withInput(Input::except('password'));
      } else {
          // store
          $nerd = new Nerds;
          $nerd->name       = Input::get('name');
          $nerd->email      = Input::get('email');
          $nerd->nerd_level = Input::get('nerd_level');
          $nerd->save();

          // redirect
          Session::flash('message', 'Successfully created nerd!');
          return Redirect::to('nerds');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      // get the nerd
          $nerd = Nerds::find($id);

          // show the view and pass the nerd to it
          return view('nerds.show', array('nerd' => $nerd));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // get the nerd
        $nerd = Nerds::find($id);
     // show the edit form and pass the nerd
      return view('nerds.edit', array('nerd' => $nerd));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      {
     // validate
     // read more on validation at http://laravel.com/docs/validation
     $rules = array(
         'name'       => 'required',
         'email'      => 'required|email',
         'nerd_level' => 'required|numeric'
     );
     $validator = Validator::make(Input::all(), $rules);

     // process the login
     if ($validator->fails()) {
         return Redirect::to('nerds/' . $id . '/edit')
             ->withErrors($validator)
             ->withInput(Input::except('password'));
     } else {
         // store
         $nerd = Nerds::find($id);
         $nerd->name       = Input::get('name');
         $nerd->email      = Input::get('email');
         $nerd->nerd_level = Input::get('nerd_level');
         $nerd->save();

         // redirect
         Session::flash('message', 'Successfully updated nerd!');
         return Redirect::to('nerds');
         }
      }
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // delete
       $nerd = Nerds::find($id);
       $nerd->delete();

       // redirect
       Session::flash('message', 'Successfully deleted the nerd!');
       return Redirect::to('nerds');
    }
}
