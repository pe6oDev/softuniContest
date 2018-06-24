<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /*
     * Връща view-то с потребителите
     */
    public function getUsers(){
        $users = User::all();
        return view('users.users',['users'=>$users]);
    }

    /**
     * postGetUsers
     *
     * Зарежда данните за страницата със статистика за потребителите
     * Използва се от AdminTable.vue
     * @param Request $request
     * @return  array
     */
    function getUsersAjax(Request $request)
    {
        $skip = (int)$request->skip;
        $take = (int)$request->take;
        $search = $request->search;
        $user_id = Auth::user()->id;

        $users = User::where('id', '!=', $user_id);
        if (($search && isset($search['email']) && $search['email'])) {
            $users = $users->where('email', 'like', '%' . $search['email'] . '%');
        }
        $count = $users->count();
        $users = $users->skip($skip)->take($take)->get();
        $stats['count'] = $count;
        $stats['data'] =  $users;

        return ['stats'=>$stats];
    }

    /**
     * сменя типа на потртебител
     * (защитено е с middleware) //TODO::
     *
     */
    public function postChangeType(Request $request){

        $this->validate($request,[
            'type'=> [
                'required',
                Rule::in(['admin', 'employee', 'partner', 'customer']),
            ],
            'userId'=>'required'
        ]);

        $user = User::find($request->userId);
        $user->type = $request->type;
        $user->save();
        return response(200);
    }
}
