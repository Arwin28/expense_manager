<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Expense;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ExpenseController extends Controller
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
        $expenses = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->where('expenses.user_id','=',Auth::user()->id)
            ->select('expenses.*', 'categories.name as category')
            ->get();

        return $expenses;
    }

    public function chart()
    {

        $expenses = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select('expenses.*', 'categories.name as category', DB::raw('SUM(amount) as amount'))
            ->groupBy('expenses.category_id')
            ->get();
            
        return $expenses;
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
            'category' => 'required',
            'description' => 'required|string|max:255',
            'amount' => 'required|max:255',

        ]);
        return Expense::create([
            'category_id' => $request['category'],
            'amount' => $request['amount'],
            'description' => $request['description'],
            'user_id' => Auth::user()->id,
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
        $expense =  Expense::findOrFail($id);
        $this->validate($request,[
            'category' => 'required',
            'description' => 'required|string|max:255',
            'amount' => 'required|max:255',
        ]);

        $expense->update($request->all());
        return ['message' => 'Updated the expense info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =  Expense::findOrFail($id);
        $user->delete();
    }

}
