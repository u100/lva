<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePasswordByAdminRequest;
use Session;
use Auth;
use App\PrivilegedAccount;
use App\User;
use Hash;
use App\VocabularyList;
use App\NativeWord;
use App\ForeignWord;
use DB;


class AdminController extends Controller
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

     public function checkPrivileges()
     {
        $privilegedEmails = PrivilegedAccount::select('email')->where('admin_status', '=', '1')->get();
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
        
        return $adminPanelAccess;
        
     }

     public function index()
     {
        $accessStatus = $this->checkPrivileges();
        if($accessStatus == 0)
        {
            Session::flash('notAdmin', 'Nie masz dostępu do wybranej podstrony.');
            return redirect('mylists');
        }
        $usersList = User::all();
        return view('admin', compact('usersList'));
     }

     public function changeToUser()
     {
        $id = key($_GET);
    
        $user = User::find($id);
        $privileged = PrivilegedAccount::where('email', '=', $user->email)->where('admin_status', '=', 1)->get();

        foreach($privileged as $record)
        {
            $record->admin_status = 0;
            
            $record->save();
        }
        $usersList = User::all();

        return view('admin', compact('usersList'));
     }

     public function changeToAdmin()
     {
        $id = key($_GET);
        $user = User::find($id);
        $privileged = PrivilegedAccount::where('email', '=', $user->email)->get();
        if(count($privileged))
        {
            foreach($privileged as $record)
            {
                $record->admin_status = 1;
                $record->save();
            }
            Session::flash('changedToAdmin', 'Użytkownikowi o adresie: '.$user->email.' przydzielono uprawnienia Administratora.');
        }else
        {
            $record = new PrivilegedAccount;
            $record->email = $user->email;
            $record->last_modified_by_account_id = Auth::id();
            $record->admin_status = 1;
            $record->save();

        }

        $usersList = User::all();
        return view('admin', compact('usersList'));
     }

     public function changePasswordByAdmin()
     {
         $id = key($_GET);
         $editedPassword = User::findOrFail($id);
 
         return view('admin.changePasswordByAdmin')->with(array('editedPassword' => $editedPassword));
     }
 
     public function updatePasswordByAdmin(UpdatePasswordByAdminRequest $request)
     {
         $id = key($_GET);
         $updatedPassword = User::findOrFail($id);
 
         $currentPassword = $request->current_password;
         $newPassword = $request->password;
         $newPasswordRepeat = $request->password_repeat;

         $hashedNewPassword = Hash::make($request->password);
         $request['password'] = $hashedNewPassword;
         unset($request['password_repeat']);
 
         $updatedPassword->update($request->all());
         Session::flash('passwordSuccessUpdated', 'Hasło zostało zmienione.');
         return redirect('admin');
     }

     public function lockAccount()
     {
        $id = key($_GET);
        $user = User::find($id);
        $toLock = PrivilegedAccount::where('email', '=', $user->email)->get();
        if(count($toLock))
        {
            $deleteStatus = 0;
            foreach($toLock as $record)
            {
                $record->admin_status = 2;
                $record->save();
                $deleteStatus = 1;
            }
        Session::flash('userLocked', 'Użytkownik o adresie: '.$user->email.' został zablokowany.');
        }else
        {
            $record = new PrivilegedAccount;
            $record->email = $user->email;
            $record->admin_status = $user->admin_status;
            $record->last_modified_by_account_id = Auth::id();
            $record->admin_status = 2;
            $record->save();
            Session::flash('userLocked', 'Użytkownik o adresie: '.$user->email.' został zablokowany.');
        }
        

        $usersList = User::all();
        return view('admin', compact('usersList'));
     }

     public function unlockAccount()
     {
        $id = key($_GET);
        $user = User::find($id);
        $toUnlock = PrivilegedAccount::where('email', '=', $user->email)->get();
        if(count($toUnlock))
        {
            foreach($toUnlock as $record)
            {
                $record->admin_status = 0;
                $record->save();
            }
        Session::flash('userUnlocked', 'Użytkownik o adresie: '.$user->email.' został odblokowany.');
        }else
        {
            $record = new PrivilegedAccount;
            $record->email = $user->email;
            $record->admin_status = $user->admin_status;
            $record->last_modified_by_account_id = Auth::id();
            $record->admin_status = 0;
            $record->save();
            Session::flash('userUnlocked', 'Użytkownik o adresie: '.$user->email.' został odblokowany.');
        }
        $usersList = User::all();
        return view('admin', compact('usersList'));
     }

     public function confirmDeleteAccountByAdmin()
     {
         return view('admin.confirmDeleteAccountByAdmin');
     }

     public function deleteAccountByAdmin()
     {
        $userID = key($_GET);
        $listsID = VocabularyList::select('id')->where('user_id', $userID)->get();
        $listsIDTable = array();
        foreach($listsID as $listID)
        {
            $listsIDTable[] = $listID->id;
        }

        $nativeIDTable = array();
        foreach($listsIDTable as $listID)
        {
            $natives = NativeWord::select('id')->where('vocabulary_list_id', $listID)->get();
            foreach($natives as $native)
            {
                $nativeIDTable[] = $native->id;
            }
        }

        $foreignIDTable = array();
        foreach($listsIDTable as $listID)
        {
            $foreigns = ForeignWord::select('id')->where('vocabulary_list_id', $listID)->get();
            foreach($foreigns as $foreign)
            {
                $foreignIDTable[] = $foreign->id;
            }
        }

        foreach($nativeIDTable as $native)
        {
            DB::table('foreign_word_native_word')->where('native_word_id','=', $native)->delete();
        }

        foreach($foreignIDTable as $foreign)
        {
            DB::table('foreign_word_native_word')->where('foreign_word_id','=', $foreign)->delete();
        }

        foreach($nativeIDTable as $native)
        {
            DB::table('native_words')->where('id','=', $native)->delete();
        }

        foreach($foreignIDTable as $foreign)
        {
            DB::table('foreign_words')->where('id','=', $foreign)->delete();
        }

        foreach($listsIDTable as $list)
        {
            DB::table('repetition_dates')->where('vocabulary_list_id','=', $list)->delete();
        }

        VocabularyList::where('user_id', '=', $userID)->delete();

        $deletedUser = User::find($userID);
        
        $deletedUserEmail = $deletedUser->email;
        $updatePrivilegesRecords = PrivilegedAccount::where('email', '=', $deletedUserEmail)->get();

        foreach($updatePrivilegesRecords as $record)
        {
            $record->email = (string)$deletedUser->id;
            $record->admin_status = -1;
            $record->save();
        }

        User::where('id', '=', $userID)->delete();

        Session::flash('accountDeleted', 'Konto zostało usunięte.');

        return redirect('admin');
    }
}
