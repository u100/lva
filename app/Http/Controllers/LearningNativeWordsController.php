<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NativeWord;
use App\ForeignWord;
use App\ForeignWordNativeWord;
use App\VocabularyList;
use App\RepetitionDate;
use App\Http\Requests\CheckGeneratedWordRequest;
use Session;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class LearningNativeWordsController extends Controller
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

    public function setRoute()
    {
        $lang_id = $_GET['lang_id'];
        $list_id = $_GET['list_id'];

        $nativeOldestRecord = NativeWord::select('id', 'updated_at')->where([
            ['vocabulary_list_id', '=', $list_id],
            ['native_to_foreign_status','=', 1],
            ['success','=', 0],
        ])->get();

        $nativeOldestRecord = $nativeOldestRecord->sortByDesc('updated_at')->first();

        $foreignOldestRecord = ForeignWord::select('id', 'updated_at')->where([
            ['vocabulary_list_id', '=', $list_id],
            ['native_to_foreign_status','=', 0],
            ['success','=', 0],
        ])->get();

        $foreignOldestRecord = $foreignOldestRecord->sortByDesc('updated_at')->first();

        if(isset($nativeOldestRecord) && isset($foreignOldestRecord))
        {
            if($nativeOldestRecord->updated_at < $foreignOldestRecord->updated_at)
            {
                return redirect()->route('learningforeign',['lang_id' => $lang_id, 'list_id' => $list_id]);
            }else{
                return redirect()->route('learningnative',['lang_id' => $lang_id, 'list_id' => $list_id]);
            }
        }elseif(isset($nativeOldestRecord))
        {
            return redirect()->route('learningnative',['lang_id' => $lang_id, 'list_id' => $list_id]);
        }elseif(isset($foreignOldestRecord))
        {
            return redirect()->route('learningforeign',['lang_id' => $lang_id, 'list_id' => $list_id]);
        }elseif(!(isset($nativeOldestRecord) || isset($foreignOldestRecord)))
        {
            $drawRemainingRecords =$this->drawRemainingRecords($list_id);
            return $drawRemainingRecords;
        }
    }

    public function drawRemainingRecords($list_id)
    {
        $native = NativeWord::where([
            ['vocabulary_list_id','=', $list_id],
            ['success','=', 0]])->get();
        $native = $native->sortBy('updated_at')->first();

        $foreign = ForeignWord::where([
            ['vocabulary_list_id','=', $list_id],
            ['success','=', 0]])->get();
        $foreign = $foreign->sortBy('updated_at')->first();

        $dbNativeStatus = 0;
        $dbForeignStatus = 0;

        if(!empty($native))
        {
            $dbNativeStatus = 1;
        }
        if(!empty($foreign))
        {
            $dbForeignStatus = 1;
        }

        if($dbNativeStatus == 1 && $dbForeignStatus == 0)
        {
            $generatedWord = $native;
            return view('learningnative')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
        }

        if($dbNativeStatus == 0 && $dbForeignStatus == 1)
        {
            $generatedWord = $foreign;
            return view('learningforeign')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
        }

        if($dbNativeStatus == 0 && $dbForeignStatus == 0)
        {
            session(['noWordsOntheList' => 'Na tej liście nie ma żadnego słowa do nauki.']);
            return redirect()->route('singlelist', ['id' => $list_id]);
        }

        if($dbNativeStatus == 1 && $dbForeignStatus == 1)
        {
            $nativeOrForeign = rand(1, 2);
            if($nativeOrForeign == 1)
            {
                $generatedWord = $native;
                return view('learningnative')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
            }
            if($nativeOrForeign == 2)
            {
                $generatedWord = $foreign;
                return view('learningforeign')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function updateWhenAnswerIncorrect($nativeUpdate, $translatedWord)
    {
        $nativeRepeatsAmount = NativeWord::select('word_repeating_counter')->find($translatedWord->id);
        $nativeUpdate[0]->update([
            'pattern' => '0'.substr($translatedWord->pattern, 0, -1),
            'native_to_foreign_status' => 0,
            'word_repeating_counter' => $nativeRepeatsAmount->word_repeating_counter + 1,
            'updated_at' => Carbon::now()
        ]);

        $pivotTableIDs = ForeignWordNativeWord::where('native_word_id', $translatedWord->id)->get();
        foreach($pivotTableIDs as $pivotID)
        {
            $foreignUpdate = ForeignWord::where('id', $pivotID->foreign_word_id)->first();

            DB::table('foreign_words')
                ->where('id', $pivotID->foreign_word_id)
                ->update(['native_to_foreign_status' => 0]);
            $pivotTableStepBackIDs = ForeignWordNativeWord::where('foreign_word_id', $foreignUpdate->id)->get();
            foreach($pivotTableStepBackIDs as $pivotStepBackID)
            {
                $pivotStepBackID = NativeWord::where('id', $pivotStepBackID->native_word_id)->first();
                $pivotStepBackID->update([
                    'native_to_foreign_status' => 0
                ]);
            }
        }
    }

    public function updateWhenAnswerCorrect($nativeUpdate, $translatedWord)
    {
        $nativeRepeatsAmount = NativeWord::select('word_repeating_counter')->find($translatedWord->id);
        $nativeUpdate[0]->update([
            'pattern' => '1'.substr($translatedWord->pattern, 0, -1),
            'native_to_foreign_status' => 0,
            'word_repeating_counter' => $nativeRepeatsAmount->word_repeating_counter + 1,
            'updated_at' => Carbon::now()
        ]);

        $pivotTableIDs = ForeignWordNativeWord::where('native_word_id', $translatedWord->id)->get();
        foreach($pivotTableIDs as $pivotID)
        {
            $foreignUpdate = ForeignWord::where('id', $pivotID->foreign_word_id)->first();

            DB::table('foreign_words')
                ->where('id', $pivotID->foreign_word_id)
                ->update(['native_to_foreign_status' => 0]);
            $pivotTableStepBackIDs = ForeignWordNativeWord::where('foreign_word_id', $foreignUpdate->id)->get();


            foreach($pivotTableStepBackIDs as $pivotStepBackID)
            {
                $pivotStepBackID = NativeWord::where('id', $pivotStepBackID->native_word_id)->first();
                $pivotStepBackID->update([
                    'native_to_foreign_status' => 0
                ]);
            }
        }

        if(substr_count($nativeUpdate[0]->pattern,'1') >= 3)
        {
            session(['wordLearned' => 'Wspaniale! Nauczyłaś/nauczyłeś się słowa '.$nativeUpdate[0]->word]);
            $nativeUpdate[0]->update([
                'success' => 1,
                'updated_at' => Carbon::now()
            ]);
        }
    }

    public function checkWord(CheckGeneratedWordRequest $request)
    {
        $translatedWord = NativeWord::find($request->word_id);
        $wordsToCompare = ForeignWordNativeWord::where([
            ['native_word_id','=', $request->word_id],
        ])->get();
        $wordsToCompareTable = array();
        for($n=0; $n < count($wordsToCompare); $n++)
        {
            $wordsToCompareTable[] = ForeignWord::find($wordsToCompare[$n]->foreign_word_id);
        }

        $matchingWord = array();
        for($i = 0; $i < count($wordsToCompareTable); $i++)
        {
            if($request->word == $wordsToCompareTable[$i]->word)
            {
                $matchingWord[] = $wordsToCompareTable[$i];
            }
        }

        if(empty($matchingWord))
        {
            //echo "umieszczono failAttempt-bledne tłum<br />";
            //Session::flash('failAttempt', 'Błędne tłumaczenie.');
            //session()->put('failAttempt', 'Błędne tłumaczenie.');
            session(['failAttempt' => 'Błędne tłumaczenie.']);
            $repeatsAmount = VocabularyList::select('general_repeating_counter')->find($translatedWord->vocabulary_list_id);
            $vocabularyListRepetingNumberIncrease = VocabularyList::where('id', $translatedWord->vocabulary_list_id)->get();
            $vocabularyListRepetingNumberIncrease[0]->update(['general_repeating_counter' => $repeatsAmount->general_repeating_counter + 1]);

            RepetitionDate::insert(['vocabulary_list_id' => $translatedWord->vocabulary_list_id, 'success_or_fail' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            $nativeUpdate = NativeWord::where('id', $translatedWord->id)->get();
            $lang_id = VocabularyList::select('language_id')->find($request->vocabulary_list_id);
            $this->updateWhenAnswerIncorrect($nativeUpdate, $translatedWord);
            return redirect()->route('setRoute', ['lang_id' => $lang_id->language_id, 'list_id' => $request->vocabulary_list_id]);
        }
        if(!empty($matchingWord))
        {
            //echo "umieszczono successAttempt-dobre tłum<br />";
            //Session::flash('successAttempt', 'Brawo! Poprawne słowo!');
            //session()->put('successAttempt', 'Brawo! Poprawne słowo!');
            session(['successAttempt' => 'Brawo! Poprawne słowo!']);

            $repeatsAmount = VocabularyList::select('general_repeating_counter')->find($translatedWord->vocabulary_list_id);
            $vocabularyListRepetingNumberIncrease = VocabularyList::where('id', $translatedWord->vocabulary_list_id)->get();
            $vocabularyListRepetingNumberIncrease[0]->update(['general_repeating_counter' => $repeatsAmount->general_repeating_counter + 1]);

            RepetitionDate::insert(['vocabulary_list_id' => $translatedWord->vocabulary_list_id, 'success_or_fail' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            $nativeUpdate = NativeWord::where('id', $translatedWord->id)->get();
            $lang_id = VocabularyList::select('language_id')->find($request->vocabulary_list_id);
            $this->updateWhenAnswerCorrect($nativeUpdate, $translatedWord);
            //return redirect()->route('setRoute', ['lang_id' => $lang_id->language_id, 'list_id' => $request->vocabulary_list_id]);
            return redirect()->route('setRoute', ['lang_id' => $lang_id->language_id, 'list_id' => $request->vocabulary_list_id]);
            //return redirect()->back();
        }
    }

    public function index()
    {
        $lang_id = $_GET['lang_id'];
        $list_id = $_GET['list_id'];

            $nativeTranslated = NativeWord::where([
                ['vocabulary_list_id','=', $list_id],
                ['native_to_foreign_status','=', 1],
                ['success','=', 0],
            ])->get();

            $nativeTranslated = $nativeTranslated->sortBy('updated_at')->first();

            if($nativeTranslated)
            {
                $generatedWord = $nativeTranslated;
                return view('learningnative')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
            }
    }
}
