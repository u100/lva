<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VocabularyList;
use App\Language;
use App\NativeWord;
use App\ForeignWord;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreateSingleListRequest;
use DB;
use Session;
use PDF;

class SingleListController extends Controller
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

    public function show($id)
    {
        $singlelist = VocabularyList::find($id);
        $nativeWords = NativeWord::where('vocabulary_list_id', $id)->orderBy('word', 'asc')->get();
        $foreignWords = ForeignWord::where('vocabulary_list_id', $id)->orderBy('word', 'asc')->get();
        $languageName = $singlelist->language->name;
        return view('singlelist.show', compact('singlelist', 'nativeWords', 'foreignWords', 'languageName'));
    }

    public function prepareLanguageList()
    {
        $languageslist = Language::orderBy('name', 'asc')->get();
        $languages = array();
        foreach ($languageslist as $arr) {
            $languages[] = $arr->name;
        }
        return $languages;
    }

    public function create()
    {
        $languages = $this->prepareLanguageList();
        return view('singlelist.create')->with(array('languages'=>$languages));
    }

    public function store(CreateSingleListRequest $request)
    {
        $request['language_id'] = $request->language_id + 1;
        VocabularyList::create($request->all());
        return redirect('mylists');
    }

    public function edit($id)
    {
        $editedlist = VocabularyList::findOrFail($id);
        $languages = $this->prepareLanguageList();
        return view('singlelist.edit')->with(array('editedlist' => $editedlist, 'languages'=>$languages));
    }

    public function update($id, CreateSingleListRequest $request)
    {
        $updatedlist = VocabularyList::findOrFail($id);
        $updatedlist->update($request->all());
        return redirect('mylists');
    }

    public function resetResults($id, Request $request)
    {
        $listId = VocabularyList::find($id)->id;
        $resetedNativeWords = DB::table('native_words')->where('vocabulary_list_id', $listId)->update(array('pattern' =>'2222', 'native_to_foreign_status' => 1, 'success' => 0));
        $resetedForeignWords = DB::table('foreign_words')->where('vocabulary_list_id', $listId)->update(array('pattern' =>'2222', 'native_to_foreign_status' => 1, 'success' => 0));
        Session::flash('resetConfirmation', 'Twoja lista jest pusta');
        return redirect('mylists');
    }

    public function generatePrintableData($id)
    {
        $nativeWordsArray[] = array();
        $foreignWordsArray[] = array();
        $nativeWords = NativeWord::where('vocabulary_list_id', $id)->get();
        $i = 0;
        foreach($nativeWords as $nativeWord){
            $foreignWords = $nativeWord->foreign_words;
            foreach($foreignWords as $foreignWord){
                $nativeWordsArray[$i] = $nativeWord->word;
                $foreignWordsArray[$i] = $foreignWord->word;
                $i++;
            }
        }
        return array($nativeWordsArray, $foreignWordsArray);
    }

    public function generatePDF($id)
    {
        $listId = VocabularyList::find($id)->id;
        $listName = VocabularyList::where('id', $listId)->first()->name;
        $PDFfileName = $listName.'.pdf';
        $generatedData = $this->generatePrintableData($id);
        $nativeWordsArray = $generatedData[0];
        $foreignWordsArray = $generatedData[1];
        if(empty($nativeWordsArray[0]) || empty($foreignWordsArray[0]))
        {
            Session::flash('wordListEmptyMessage', 'Twoja lista jest pusta');
            return redirect('mylists');
        }

        $pdfContent = PDF::loadView('singlelist.pdf', ['nativeWordsArray' => $nativeWordsArray, 'foreignWordsArray' => $foreignWordsArray, 'listName' => $listName]);
        return $pdfContent->download($PDFfileName);
    }

    public function generateCSV($id)
    {

        $listId = VocabularyList::find($id)->id;
        $listName = VocabularyList::where('id', $listId)->first()->name;
        $CSVfileName = $listName.'.csv';
        $generatedData = $this->generatePrintableData($id);
        $nativeWordsArray = $generatedData[0];
        $foreignWordsArray = $generatedData[1];
        if(empty($nativeWordsArray[0]) || empty($foreignWordsArray[0]))
        {
            Session::flash('wordListEmptyMessage', 'Twoja lista jest pusta');
            return redirect('mylists');
        }

        $csvFile = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csvFile->insertOne(\Schema::getColumnListing('nativeWordsArray'));

        for($i=0; $i < count($nativeWordsArray); $i++)
        {
            $wordsPair = $nativeWordsArray[$i].' - '.$foreignWordsArray[$i];
            $csvFile->insertOne($wordsPair);
        }

        return $csvFile->output($CSVfileName);
    }

    public function deleteList($id)
    {
                $deletingList = VocabularyList::find($id);
                $deletingList->native_words()->delete();
                $deletingList->foreign_words()->delete();
                
                if($deletingList->where('id', $id)->update(array('active' => 0)))
                {
                    Session::flash('successListRemoval', 'Twoja lista i należące do niej słowa zostały usunięte.');
                }else
                {
                    Session::flash('failListRemoval', 'Wystąpił problem z usuwaniem listy');
                }
                
        return redirect('mylists');
    }
}