<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNativeOrForeignWordRequest;
use App\NativeWord;
use App\ForeignWord;
use App\ForeignWordNativeWord;
use Session;

class NativeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang_id = $_GET['lang_id'];
        $list_id = $_GET['list_id'];
        return view('native.create')->with(array('lang_id'=>$lang_id, 'list_id' => $list_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNativeOrForeignWordRequest $request)
    {
        $vocabularyListID = $request->vocabulary_list_id;
        $firstTranslation = $request->first_translation;
        $secondTranslation = $request->second_translation;
        $thirdTranslation = $request->third_translation;
        unset($request['first_translation']);
        unset($request['second_translation']);
        unset($request['third_translation']);

        $correctSaveStatus = 1;
        $foreignWord1ID = 0;
        $foreignWord2ID = 0;
        $foreignWord3ID = 0;

        $nativeWord = NativeWord::create($request->all());

        if(!$nativeWord->id)
        {
            $correctSaveStatus = 0;
        }

        if($correctSaveStatus == 1)
        {
            if(!empty($firstTranslation))
            {
                $firstForeignTranslation['vocabulary_list_id'] = $vocabularyListID;
                $firstForeignTranslation['word'] = $firstTranslation;
                $firstForeignTranslation['pattern'] = '2222';
                $firstForeignTranslation['native_to_foreign_status'] = 1;
                $firstForeignTranslation['word_repeating_counter'] = 0;
                $firstForeignTranslation['success'] = 0;
                $savedForeignWord1 = ForeignWord::create($firstForeignTranslation);
                $foreignWord1ID = $savedForeignWord1->id;

                $firstTranslationPivotRecord['foreign_word_id'] = $foreignWord1ID;
                $firstTranslationPivotRecord['native_word_id'] = $nativeWord->id;
                $firstTranslationPivotRecord = ForeignWordNativeWord::create($firstTranslationPivotRecord);
            }

            if(!empty($secondTranslation))
            {
                $secondForeignTranslation['vocabulary_list_id'] = $vocabularyListID;
                $secondForeignTranslation['word'] = $secondTranslation;
                $secondForeignTranslation['pattern'] = '2222';
                $secondForeignTranslation['native_to_foreign_status'] = 1;
                $secondForeignTranslation['word_repeating_counter'] = 0;
                $secondForeignTranslation['success'] = 0;
                $savedForeignWord2 = ForeignWord::create($secondForeignTranslation);
                $foreignWord2ID = $savedForeignWord2->id;

                $secondTranslationPivotRecord['foreign_word_id'] = $foreignWord2ID;
                $secondTranslationPivotRecord['native_word_id'] = $nativeWord->id;
                $secondTranslationPivotRecord = ForeignWordNativeWord::create($secondTranslationPivotRecord);
            }

            if(!empty($thirdTranslation))
            {
                $thirdForeignTranslation['vocabulary_list_id'] = $vocabularyListID;
                $thirdForeignTranslation['word'] = $thirdTranslation;
                $thirdForeignTranslation['pattern'] = '2222';
                $thirdForeignTranslation['native_to_foreign_status'] = 1;
                $thirdForeignTranslation['word_repeating_counter'] = 0;
                $thirdForeignTranslation['success'] = 0;
                $savedForeignWord3 = ForeignWord::create($thirdForeignTranslation);
                $foreignWord3ID = $savedForeignWord3->id;

                $thirdTranslationPivotRecord['foreign_word_id'] = $foreignWord3ID;
                $thirdTranslationPivotRecord['native_word_id'] = $nativeWord->id;
                $thirdTranslationPivotRecord = ForeignWordNativeWord::create($thirdTranslationPivotRecord);
            }
        }

        if($correctSaveStatus == 1)
        {
            Session::flash('successNativeOrForeignWordSave', 'Słowo zostało dodane.');
        }elseif($correctSaveStatus == 0)
        {
            Session::flash('failNativeOrForeignWordSave', 'Wystąpił problem z dodawaniem słowa.');
        }
        return redirect('singlelist/'.$vocabularyListID);
    }
}
