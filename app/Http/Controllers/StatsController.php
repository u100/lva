<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\RepetitionDate;
use App\VocabularyList;
use App\Language;
use Auth;
use Carbon\Carbon;

class StatsController extends Controller
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

     public function generateTotalStats()
     {
        $usersAmount = User::count();
        $repetitionsSum = RepetitionDate::sum('success_or_fail');

        return array($usersAmount, $repetitionsSum);
     }
 
     public function generateUsersRating()
     {
        $users_table = User::all();
        $usersRatingPreparation = array();

        foreach($users_table as $user_table)
        {
            $repeatsSumForUser = $user_table->vocabulary_lists->pluck('general_repeating_counter');

            $userRepeats = 0;
                foreach($repeatsSumForUser as $value)
                {
                    $userRepeats += $value;
                }

            $usersRatingPreparation[$user_table->name] = $userRepeats;

        }
        $usersRating = array();
        arsort($usersRatingPreparation);
        $usersRating = array_slice($usersRatingPreparation, 0, 5, true);
        return $usersRating;
     }
 
     public function generateStatsPerLanguage()
     {
         $languages_list = Language::where('name', '<>', '')->get();
         $languagesRepeatsCounter = array();


         foreach($languages_list as $singleLanguage)
         {
             $repeatsSumForLanguage = $singleLanguage->vocabulary_lists->pluck('general_repeating_counter');
             $singleLanguageRepeats = 0;
             foreach($repeatsSumForLanguage as $value)
             {
                 $singleLanguageRepeats += $value;
             }
             $languagesRepeatsCounter[$singleLanguage->name] = $singleLanguageRepeats;

         }
         $languagesRating = array();
         arsort($languagesRepeatsCounter);
         $languagesRating = array_slice($languagesRepeatsCounter, 0, 5, true);
         return $languagesRating;
     }

     public function lastYearStats()
     {
         $allUserListsID = VocabularyList::where(['user_id' => Auth::id()])->get();
         $now = Carbon::now();
         $yearlyRepeatsCounter = 0;

         foreach($allUserListsID as $userList)
         {
             $repetitionDatesForList = $userList->repetition_dates;

              foreach($repetitionDatesForList as $value)
              {
                  $record = $value->created_at;

                  if($record->lt($now))
                  {
                      if($record->diffInDays($now) <= 365)
                      {
                          $yearlyRepeatsCounter += 1;
                      }
                  }
              }
         }

        return $yearlyRepeatsCounter;
     }

    public function lastDaysStats()
    {
        $allUserListsID = VocabularyList::where(['user_id' => Auth::id()])->get();
        $now = Carbon::now();
        $lastDaysRepeatsCounter = 0;
        $dailyRepeatsCounter = 0;

        foreach($allUserListsID as $userList)
        {
            $repetitionDatesForList = $userList->repetition_dates;

            foreach($repetitionDatesForList as $value)
            {
                $record = $value->created_at;
                if($record->lt($now))
                {
                    if($record->diffInDays($now) <= 30)
                    {
                        $lastDaysRepeatsCounter += 1;
                    }
                    if($record->diffInDays($now) == 0 && $record->day == $now->day)
                    {
                        $dailyRepeatsCounter += 1;
                    }
                }
            }
        }
        return array($lastDaysRepeatsCounter, $dailyRepeatsCounter);
    }

    public function tablesStats()
    {
        $allUserLists = VocabularyList::where(['user_id' => Auth::id()])->get();
        $mostOverallRepeatsTableName = '';
        $mostOverallRepeatsTableValue = 0;
        $mostSuccessRepeatsTableName = '';
        $mostSuccessRepeatsTableValue = 0;

        foreach($allUserLists as $userList)
        {
            if($userList->repetition_dates->count() > $mostOverallRepeatsTableValue)
            {
                $mostOverallRepeatsTableName = $userList->name;
                $mostOverallRepeatsTableValue = $userList->repetition_dates->count();
            }

            if($userList->repetition_dates->where('success_or_fail', 1)->count() > $mostSuccessRepeatsTableValue)
            {
                $mostSuccessRepeatsTableName = $userList->name;
                $mostSuccessRepeatsTableValue = $userList->repetition_dates->where('success_or_fail', 1)->count();
            }
        }
        return array($mostOverallRepeatsTableName, $mostOverallRepeatsTableValue, $mostSuccessRepeatsTableName, $mostSuccessRepeatsTableValue);
    }

     public function generateMainStats()
     {
         $lastYearStats = $this->lastYearStats();
         $lastDaysStats = $this->lastDaysStats();
         $tablesStats = $this->tablesStats();
         return array($lastYearStats, $lastDaysStats, $tablesStats);
     }

    public function index()
    {
        $totalStats = $this->generateTotalStats();
        $usersRating = $this->generateUsersRating();
        $languagesStats = $this->generateStatsPerLanguage();
        $mainStats = $this->generateMainStats();
        return view('stats', compact('totalStats', 'usersRating', 'languagesStats', 'mainStats'));
    }
}

