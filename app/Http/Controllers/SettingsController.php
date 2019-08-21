<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Session;
use Hash;
use DB;
use App\VocabularyList;
use App\NativeWord;
use App\ForeignWord;

class SettingsController extends Controller
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

    public function index()
    {
        return view('settings');
    }

    public function editName()
    {
        $id = Auth::id();
        $editedName = User::findOrFail($id);
        return view('settings.editName')->with(array('editedName' => $editedName));
    }

    public function updateName(UpdateNameRequest $request)
    {
        $id = Auth::id();
        $updatedUser = User::findOrFail($id);
        $updatedUser->update($request->all());
        Session::flash('nameSuccessUpdated', 'Twoja nazwa została zaktualizowana.');
        return redirect('settings');
    }

    public function changeEmail()
    {
        $id = Auth::id();
        $editedEmail = User::findOrFail($id);
        return view('settings.changeEmail')->with(array('editedEmail' => $editedEmail));
    }

    public function updateEmail(UpdateEmailRequest $request)
    {
        $id = Auth::id();
        $updatedEmail = User::findOrFail($id);
        $updatedEmail->update($request->all());
        Session::flash('emailSuccessUpdated', 'Twój adres email został zmieniony.');
        return redirect('settings');
    }

    public function changePassword()
    {
        $id = Auth::id();
        $editedPassword = User::findOrFail($id);

        return view('settings.changePassword')->with(array('editedPassword' => $editedPassword));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $id = Auth::id();
        $updatedPassword = User::findOrFail($id);

        $currentPassword = $request->current_password;
        $newPassword = $request->password;
        $newPasswordRepeat = $request->password_repeat;

        if(!Hash::check($currentPassword, $updatedPassword->password))
        {
            Session::flash('passwordsIncorrect', 'Bieżące hasło jest nieprawidłowe');
            return redirect()->back();
        }

        if($newPassword != $newPasswordRepeat)
        {
            Session::flash('passwordsNotTheSame', 'Nowe hasło i jego powtórzenie różnią się');
            return redirect()->back();
        }

        $hashedNewPassword = Hash::make($request->password);
        $request['password'] = $hashedNewPassword;
        unset($request['current_password']);
        unset($request['password_repeat']);

        $updatedPassword->update($request->all());
        Session::flash('passwordSuccessUpdated', 'Twoje hasło zostało zmienione.');
        return redirect('settings');
    }

    public function confirmDeleteAccount()
    {
        return view('settings.confirmDeleteAccount');
    }
    
    public function deleteAll()
    {
        $userID = Auth::id();
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

        User::where('id', '=', $userID)->delete();

        Session::flash('accountDeleted', 'Twoje konto zostało usunięte.');

        Auth::logout();

        return redirect('login');
    }


}
