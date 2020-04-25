<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\DB;
use DateTime;

class TaskController extends Controller
{
//    public function index()
//    {
//        $tasks = Task::orderBy("id", "DESC")->paginate(5);
//        return response()->json($tasks);
//    }

    public function index(Request $request){
        $arr = str_replace("%", "#", $request->get('search'));
        $par = self::from_unicode($arr);
        $res= $request->get('selected');


        $query =  DB::table('vwTask');

        if(!empty($res['roles'])){
            $query->whereIn('role',  $res['roles']);
        };
        if(!empty($res['statuses'])){
            $query->whereIn('statusName',  $res['statuses']);
        };
        if(!empty($res['directors'])){
            $query->whereIn('directorName',  $res['directors']);
        };
        if(!empty($res['responsible'])){
            $query->whereIn('responsibleName',  $res['responsible']);
        };
        if(!empty($res['date_end'])){

            $dt = new DateTime();
            $query->where('responsibleName', '<=', $dt->setTimestamp(strtotime($res['date_end']))->format('Y-m-d H:i'));
        };
        if(!empty($res['name'])){
            $query->where('name', 'like', '%'.$res['name'].'%');
        };

        switch ($request->get('opt')) {
            case 'responsible':

                $query->where('responsibleName', 'like', '%'.$par.'%');
                $query->selectRaw('responsibleName as name');
                $query->groupBy('responsibleName');

                break;
            case 'directors':
                $query->where('directorName', 'like', '%'.$par.'%');
                $query->selectRaw('directorName as name');
                $query->groupBy('directorName');
                break;

            case 'statuses':
                $query->where('statusName', 'like', '%'.$par.'%');
                $query->selectRaw('statusName as name');
                $query->groupBy('statusName');
                break;

            case 'roles':
                $query->where('role', 'like', '%'.$par.'%');
                $query->selectRaw('role as name');
                $query->groupBy('role');
                break;

        }

        if($request->get('opt') === null){
            $rows = $query->paginate(5);
        }else{
            $rows = $query->get();
        }


        return $rows;
    }

    public function from_unicode ($text) {
        return str_ireplace(array("#U0430", "#U0431", "#U0432",
            "#U0433", "#U0434", "#U0435", "#U0451", "#U0436", "#U0437", "#U0438",
            "#U0439", "#U043A", "#U043B", "#U043C", "#U043D", "#U043E", "#U043F",
            "#U0440", "#U0441", "#U0442", "#U0443", "#U0444", "#U0445", "#U0446",
            "#U0447", "#U0448", "#U0449", "#U044A", "#U044B", "#U044C", "#U044D",
            "#U044E", "#U044F", "#U0410", "#U0411", "#U0412", "#U0413", "#U0414",
            "#U0415", "#U0401", "#U0416", "#U0417", "#U0418", "#U0419", "#U041A",
            "#U041B", "#U041C", "#U041D", "#U041E", "#U041F", "#U0420", "#U0421",
            "#U0422", "#U0423", "#U0424", "#U0425", "#U0426", "#U0427", "#U0428",
            "#U0429", "#U042A", "#U042B", "#U042C", "#U042D", "#U042E", "#U042F",
            "#U0021", "#U0027", "#U0028", "#U0029", "#U002B", "#U002C", "#U003D",
            "#U0040", "#U0060", "#U005F", "#U002D", "#U002E", "#U00A7", "#U00AB",
            "#U00BB", "#U00B0", "#U0031", "#U0032", "#U0033", "#U0034", "#U0035",
            "#U0036", "#U0037", "#U0038", "#U0039", "#U0030", "#U2116", "#U0020"),
            array("а", "б", "в",
                "г", "д", "е", "ё", "ж", "з", "и",
                "й", "к", "л", "м", "н", "о", "п",
                "р", "с", "т", "у", "ф", "х", "ц",
                "ч", "ш", "щ", "ъ", "ы", "ь", "э",
                "ю", "я", "А", "Б", "В", "Г", "Д",
                "Е", "Ё", "Ж", "З", "И", "Й", "К",
                "Л", "М", "Н", "О", "П", "Р", "С",
                "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш",
                "Щ", "Ъ", "Ы", "Ь", "Э", "Ю", "Я",
                "!", "\'", "(", ")", "+", ",", "=",
                "@", "`", "_", "-", ".", "§", "«",
                "»", "°", "1", "2", "3", "4", "5",
                "6", "7", "8", "9", "0", "№", " "),
            $text);
    }
}
