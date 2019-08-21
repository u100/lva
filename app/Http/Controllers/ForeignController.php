<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNativeOrForeignWordRequest;
use App\NativeWord;
use App\ForeignWord;
use App\ForeignWordNativeWord;
use Session;

class ForeignController extends Controller
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
        return view('foreign.create')->with(array('lang_id'=>$lang_id, 'list_id' => $list_id));
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
        $nativeWord1ID = 0;
        $nativeWord2ID = 0;
        $nativeWord3ID = 0;

        $foreignWord = ForeignWord::create($request->all());

        if(!$foreignWord->id)
        {
            $correctSaveStatus = 0;
        }

        if($correctSaveStatus == 1)
        {
            if(!empty($firstTranslation))
            {
                $firstNativeTranslation['vocabulary_list_id'] = $vocabularyListID;
                $firstNativeTranslation['word'] = $firstTranslation;
                $firstNativeTranslation['pattern'] = '2222';
                $firstNativeTranslation['native_to_foreign_status'] = 1;
                $firstNativeTranslation['word_repeating_counter'] = 0;
                $firstNativeTranslation['success'] = 0;
                $savedNativeWord1 = NativeWord::create($firstNativeTranslation);
                $nativeWord1ID = $savedNativeWord1->id;

                $firstTranslationPivotRecord['native_word_id'] = $nativeWord1ID;
                $firstTranslationPivotRecord['foreign_word_id'] = $foreignWord->id;
                $firstTranslationPivotRecord = ForeignWordNativeWord::create($firstTranslationPivotRecord);
            }

            if(!empty($secondTranslation))
            {
                $secondNativeTranslation['vocabulary_list_id'] = $vocabularyListID;
                $secondNativeTranslation['word'] = $secondTranslation;
                $secondNativeTranslation['pattern'] = '2222';
                $secondNativeTranslation['native_to_foreign_status'] = 1;
                $secondNativeTranslation['word_repeating_counter'] = 0;
                $secondNativeTranslation['success'] = 0;
                $savedNativeWord2 = NativeWord::create($secondNativeTranslation);
                $nativeWord2ID = $savedNativeWord2->id;

                $secondTranslationPivotRecord['native_word_id'] = $nativeWord2ID;
                $secondTranslationPivotRecord['foreign_word_id'] = $foreignWord->id;
                $secondTranslationPivotRecord = ForeignWordNativeWord::create($secondTranslationPivotRecord);
            }

            if(!empty($thirdTranslation))
            {
                $thirdNativeTranslation['vocabulary_list_id'] = $vocabularyListID;
                $thirdNativeTranslation['word'] = $thirdTranslation;
                $thirdNativeTranslation['pattern'] = '2222';
                $thirdNativeTranslation['native_to_foreign_status'] = 1;
                $thirdNativeTranslation['word_repeating_counter'] = 0;
                $thirdNativeTranslation['success'] = 0;
                $savedNativeWord3 = NativeWord::create($thirdNativeTranslation);
                $nativeWord3ID = $savedNativeWord3->id;

                $thirdTranslationPivotRecord['native_word_id'] = $nativeWord3ID;
                $thirdTranslationPivotRecord['foreign_word_id'] = $foreignWord->id;
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
