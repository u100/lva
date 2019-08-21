<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\VocabularyList;
use App\PrivilegedAccount;
use Session;

class MyListsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function checkPrivileges()
     {
        $privilegedEmails = PrivilegedAccount::select('email')->where('admin_status', '=', '1')->get();
        $blockedEmails = PrivilegedAccount::select('email')->where('admin_status', '=', '2')->get();
        $adminPanelAccess = 0;
        $i = 0;
        foreach($privilegedEmails as $privilegedEmail)
        {
            if($privilegedEmails[$i]->email === Auth::user()->email)
            {
               $adminPanelAccess = 1;
            }

            $i++;
        }

        if(count($blockedEmails) > 0)
        {
           
            $j = 0;
            foreach($blockedEmails as $blockedEmail)
            {
                if($blockedEmails[$j]->email === Auth::user()->email)
                {
                   $adminPanelAccess = 2;
                }
    
                $j++;
            }
        }

        return $adminPanelAccess;
     }
        
    public function index()
    {

        $mylists = VocabularyList::where(['user_id' => Auth::id(), 'active' => 1])->orderBy('name', 'asc')->get();

        $adminPanelAccessLink = 0;

        if($this->checkPrivileges() === 1)
        {
            $adminPanelAccessLink = 1;
        }

        if($this->checkPrivileges() === 2)
        {
            Session::flash('userBanned', 'To konto jest zablokowane.');
            Auth::logout();
            return view('auth.login');
        }

        return view('mylists', compact('mylists', 'adminPanelAccessLink'));
    }
}
