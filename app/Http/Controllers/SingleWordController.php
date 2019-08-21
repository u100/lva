<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NativeWord;
use App\ForeignWord;
use Session;
use DB;
use App\Http\Requests\CreateSingleWordRequest;

class SingleWordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeNative(CreateSingleListRequest $request)
    {
        NativeWord::create($request->all());
        return redirect()->back();
    }

    public function storeForeign(CreateSingleListRequest $request)
    {
        ForeignWord::create($request->all());
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editNative($id)
    {
        $nativeOrForeignID = substr($id, -1);
        $correctID = substr_replace($id, "", -1);
        $correctID = (int)$correctID;
        $editedNativeWord = NativeWord::findOrFail($correctID);
        return view('singleword.editNative')->with(array('editedNativeWord' => $editedNativeWord));
    }

    public function editForeign($id)
    {
        $nativeOrForeignID = substr($id, -1);
        $correctID = substr_replace($id, "", -1);
        $correctID = (int)$correctID;
        $editedForeignWord = ForeignWord::findOrFail($correctID);
        return view('singleword.editForeign')->with(array('editedForeignWord' => $editedForeignWord));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateNative($id, CreateSingleWordRequest $request)
    {
        $updatedNativeWord = NativeWord::findOrFail($id);
        $updatedNativeWord->update($request->all());
        return redirect('mylists');
    }

    public function updateForeign($id, CreateSingleWordRequest $request)
    {
        $updatedForeignWord = ForeignWord::findOrFail($id);
        $updatedForeignWord->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteWord($id)
    {
        $deletingWordID = explode('-', $id);
        $nativeID = $deletingWordID[0];
        $foreignID = $deletingWordID[1];

        $remainingNativeNativeRecordsID = DB::table('foreign_word_native_word')->select('native_word_id')->where([['native_word_id','=', $nativeID]])->get();
        $remainingForeignNativeRecordsID = DB::table('foreign_word_native_word')->select('foreign_word_id')->where([['native_word_id','=', $nativeID]])->get();
        $remainingNativeForeignRecordsID = DB::table('foreign_word_native_word')->select('native_word_id')->where([['foreign_word_id','=', $foreignID]])->get();
        $remainingForeignForeignRecordsID = DB::table('foreign_word_native_word')->select('foreign_word_id')->where([['foreign_word_id','=', $foreignID]])->get();

        $deletingNativeIDTable = array();
        $deletingForeignIDTable = array();

        foreach($remainingNativeNativeRecordsID as $id)
        {
            if(!in_array($id->native_word_id, $deletingNativeIDTable))
            {
                $deletingNativeIDTable[] = $id->native_word_id;
            }
        }

        foreach($remainingForeignNativeRecordsID as $id)
        {
            if(!in_array($id->foreign_word_id, $deletingForeignIDTable))
            {
                $deletingForeignIDTable[] = $id->foreign_word_id;
            }
        }

        foreach($remainingNativeForeignRecordsID as $id)
        {
            if(!in_array($id->native_word_id, $deletingNativeIDTable))
            {
                $deletingNativeIDTable[] = $id->native_word_id;
            }
        }

        foreach($remainingForeignForeignRecordsID as $id)
        {
            if(!in_array($id->foreign_word_id, $deletingForeignIDTable))
            {
                $deletingForeignIDTable[] = $id->foreign_word_id;
            }
        }
        $deletingNative = DB::table('native_words')->where([['id','=', $nativeID]])->delete();
        $deletingForeign = DB::table('foreign_words')->where([['id','=', $foreignID]])->delete();

        foreach($deletingForeignIDTable as $forID)
        {
            DB::table('foreign_words')->where([['id','=', $forID]])->delete();
        }

        foreach($deletingNativeIDTable as $natID)
        {
            DB::table('native_words')->where([['id','=', $natID]])->delete();
        }

        if($deletingNative && $deletingForeign)
        {
            Session::flash('successWordRemoval', 'Słowo i jego tłumaczenie zostały usunięte.');
        }else
        {
            Session::flash('failWordRemoval', 'Wystąpił problem z usuwaniem słowa.');
        }

        return redirect()->back();
    }
}
