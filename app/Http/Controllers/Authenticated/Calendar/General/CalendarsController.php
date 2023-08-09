<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;

            // $getDateと$getPartを組み合わせて、日付をキー、部分を値とする連想配列を作成
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // 予約可能な空き枠を減らす
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        // 予約された日付を変数に格納

        $delete_date = ReserveSettings::where('setting_reserve',$request->delete_date)->where('setting_part', $request->getPart)->where('id', $request->delete_date->users()->id);
dd($delete_date);
        // 予約可能な空き枠を増やす
        $delete_date->increment('limit_users');


        User::findOrFail($id)->reserveSettings($delete_date->id)->delete();
        return redirect("deleteParts");

    }
}
