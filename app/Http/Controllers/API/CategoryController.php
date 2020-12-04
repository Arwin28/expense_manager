<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin')  || \Gate::allows('isAuthor')) {

            $categories= Category::all()->map(function ($category) {
                return $category;
            });
            return $categories;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);
        return Category::create([
            'name' => $request['name'],
        ]);
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
        $category =  Category::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        $category->update($request->all());
        return ['message' => 'Updated the category info'];
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $user =  Category::findOrFail($id);
        $user->delete();
    }

    public function get_data_dropdown()
    {
        $collection = Category::get(['name','id']);
        foreach ($collection as $item) {
            $inven[$item->id]  = $item->name;
        }
        return response()->json($inven ,200);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getCountries()
    {
        $data = Category::get();

        return response()->json($data);
    }
}
