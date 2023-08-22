<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        // <td
        // 背景色など
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){ //今日より後ろの場合
          $html[] = '<td class="day-blank">';
        }else{ //今日より未来の場合
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        // 日付の記述
        $html[] = $day->render();

        // フォーム
        if(in_array($day->everyDay(), $day->authReserveDay())){ //既に予約をされている日
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;

          // 表示内容の条件
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){ //今日より過去の場合
            if($reservePart == 1){ //1に参加
            $reservePart = "1部参加";
            }else if($reservePart == 2){ //2に参加
            $reservePart = "2部参加";
            }else if($reservePart == 3){ //3に参加
            $reservePart = "3部参加";
            }
          }else{ //今日より未来の場合
            if($reservePart == 1){ //1を予約
            $reservePart = "リモ1部";
            }else if($reservePart == 2){ //2を予約
            $reservePart = "リモ2部";
            }else if($reservePart == 3){ //3を予約
            $reservePart = "リモ3部";
            }
          }

          // 表示方法の条件
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){//今日より過去の場合:参加した部の表示
            $html[] =  $reservePart ;
          }else{ //今日より未来の場合:参加予定の部の表示、キャンセルボタン
            $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
            $reserveDate = $day->authReserveDate($day->everyDay())->first()->setting_reserve;
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75 js-modal-open" reserveDate="'. $reserveDate .'" reservePart="'. $reservePart .'"  style="font-size:12px" value="" >リモ'. $reservePart .'部</button>';//キャンセルボタン

            // モーダルの中身
            $html[] = '<div class="modal js-modal">';
              $html[] = '<div class="modal__bg js-modal-close"></div>';
              $html[] = '<div class="modal__content">';
                // 予約日、部表示
                $html[] = '<p class="reserveDate"></p>';
                $html[] = '<p class="reservePart"></p>';
                $html[] = '<p class="">上記の予約をキャンセルしてもよろしいですか？</p>';
                $html[] = '<button  class="btn btn-primary js-modal-close">閉じる</button>';

                // キャンセルボタン
                $html[] = '<button type="submit" class="btn btn-danger id="cancelButton" form="deleteParts">キャンセル</button>';
                $html[] = '<div class="delete">';
                $html[] = '<input type="hidden" class="getPart" name="getPart" value="" form="deleteParts">';
                $html[] = '<input type="hidden" class="delete_date" name="delete_date" value="" form="deleteParts">';
                $html[] = '</div>';
                $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

              $html[] = '</div>';
            $html[] = '</div>';

          }

        }else{ // 予約していない日
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){ //今日より後ろの場合
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
            $html[] = '<p hidden>' .$day->selectPart($day->everyDay()). '</p>';
          }else{ //今日より未来の場合 予約
            // プルダウン選択の表示
            $html[] = $day->selectPart($day->everyDay());
          }
          $html[] = $day->getDate();
        }

        $html[] = '</td>';
        // /td>
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
