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
use Carbon\Carbon;
use DB;

class LearningForeignWordsController extends Controller
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

    public function updateWhenAnswerIncorrect($foreignUpdate, $translatedWord)
    {
        $foreignRepeatsAmount = ForeignWord::select('word_repeating_counter')->find($translatedWord->id);
        $foreignUpdate[0]->update([
            'pattern' => '0'.substr($translatedWord->pattern, 0, -1),
            'native_to_foreign_status' => 1,
            'word_repeating_counter' => $foreignRepeatsAmount->word_repeating_counter + 1,
            'updated_at' => Carbon::now()
        ]);

        $pivotTableIDs = ForeignWordNativeWord::where('foreign_word_id', $translatedWord->id)->get();
        foreach($pivotTableIDs as $pivotID)
        {
            $nativeUpdate = NativeWord::where('id', $pivotID->native_word_id)->first();

            DB::table('native_words')
                ->where('id', $pivotID->native_word_id)
                ->update(['native_to_foreign_status' => 1]);

            $pivotTableStepBackIDs = ForeignWordNativeWord::where('native_word_id', $nativeUpdate->id)->get();
            foreach($pivotTableStepBackIDs as $pivotStepBackID)
            {
                $pivotStepBackID = ForeignWord::where('id', $pivotStepBackID->foreign_word_id)->first();
                $pivotStepBackID->update([
                    'native_to_foreign_status' => 1
                ]);
            }
        }
    }

    public function updateWhenAnswerCorrect($foreignUpdate, $translatedWord)
    {
        $foreignRepeatsAmount = ForeignWord::select('word_repeating_counter')->find($translatedWord->id);
        $foreignUpdate[0]->update([
            'pattern' => '1'.substr($translatedWord->pattern, 0, -1),
            'native_to_foreign_status' => 1,
            'word_repeating_counter' => $foreignRepeatsAmount->word_repeating_counter + 1,
            'updated_at' => Carbon::now()
        ]);

        $pivotTableIDs = ForeignWordNativeWord::where('foreign_word_id', $translatedWord->id)->get();
        foreach($pivotTableIDs as $pivotID)
        {
            $nativeUpdate = NativeWord::where('id', $pivotID->native_word_id)->first();

            DB::table('native_words')
                ->where('id', $pivotID->native_word_id)
                ->update(['native_to_foreign_status' => 1]);
            $pivotTableStepBackIDs = ForeignWordNativeWord::where('native_word_id', $nativeUpdate->id)->get();//sprawdz, zmienine z foreign na native-id


            foreach($pivotTableStepBackIDs as $pivotStepBackID)
            {
                $pivotStepBackID = ForeignWord::where('id', $pivotStepBackID->foreign_word_id)->first();
                $pivotStepBackID->update([
                    'native_to_foreign_status' => 1
                ]);
            }
        }

        if(substr_count($foreignUpdate[0]->pattern,'1') >= 3)
        {
            $foreignUpdate[0]->update([
                'success' => 1,
                'updated_at' => Carbon::now()
            ]);

            session(['wordLearned' => 'Wspaniale! Nauczyłaś/nauczyłeś się słowa '.$foreignUpdate[0]->word]);
        }
    }

    public function checkWord(CheckGeneratedWordRequest $request)
    {
        $translatedWord = ForeignWord::find($request->word_id);
        $wordsToCompare = ForeignWordNativeWord::where([
            ['foreign_word_id','=', $request->word_id],
        ])->get();
        $wordsToCompareTable = array();
        for($n=0; $n < count($wordsToCompare); $n++)
        {
            $wordsToCompareTable[] = NativeWord::find($wordsToCompare[$n]->native_word_id);
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
            session(['failAttempt' => 'Błędne tłumaczenie.']);
            $repeatsAmount = VocabularyList::select('general_repeating_counter')->find($translatedWord->vocabulary_list_id);
            $vocabularyListRepetingNumberIncrease = VocabularyList::where('id', $translatedWord->vocabulary_list_id)->get();
            $vocabularyListRepetingNumberIncrease[0]->update(['general_repeating_counter' => $repeatsAmount->general_repeating_counter + 1]);

            RepetitionDate::insert(['vocabulary_list_id' => $translatedWord->vocabulary_list_id, 'success_or_fail' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            $foreignUpdate = ForeignWord::where('id', $translatedWord->id)->get();
            $lang_id = VocabularyList::select('language_id')->find($request->vocabulary_list_id);
            $this->updateWhenAnswerIncorrect($foreignUpdate, $translatedWord);

            return redirect()->route('setRoute', ['lang_id' => $lang_id->language_id, 'list_id' => $request->vocabulary_list_id]);
        }
        if(!empty($matchingWord))
        {
            session(['successAttempt' => 'Brawo! Poprawne słowo!']);

            $repeatsAmount = VocabularyList::select('general_repeating_counter')->find($translatedWord->vocabulary_list_id);
            $vocabularyListRepetingNumberIncrease = VocabularyList::where('id', $translatedWord->vocabulary_list_id)->get();
            $vocabularyListRepetingNumberIncrease[0]->update(['general_repeating_counter' => $repeatsAmount->general_repeating_counter + 1]);

            RepetitionDate::insert(['vocabulary_list_id' => $translatedWord->vocabulary_list_id, 'success_or_fail' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            $foreignUpdate = ForeignWord::where('id', $translatedWord->id)->get();
            $lang_id = VocabularyList::select('language_id')->find($request->vocabulary_list_id);
            $this->updateWhenAnswerCorrect($foreignUpdate, $translatedWord);

            return redirect()->route('setRoute', ['lang_id' => $lang_id->language_id, 'list_id' => $request->vocabulary_list_id]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang_id = $_GET['lang_id'];
        $list_id = $_GET['list_id'];

            $foreignTranslated = ForeignWord::where([
                ['vocabulary_list_id','=', $list_id],
                ['native_to_foreign_status','=', 0],
                ['success','=', 0],
            ])->get();

            $foreignTranslated = $foreignTranslated->sortBy('updated_at')->first();

            if($foreignTranslated)
            {
                $generatedWord = $foreignTranslated;

                return view('learningforeign')->with(array('generatedWord'=>$generatedWord, 'list_id'=>$list_id));
            }
    }
}
