<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\OrderChart;
use App\Charts\PetChart;
use App\Charts\ConditionChart;
use App\Models\Grooming;
use DB;
use App\Models\Consultation;
use App\Models\Pet;
use App\Models\User;
use App\Models\Condition;
class DashboardController extends Controller
{
    public function __construct(){
        $this->bgcolor = collect(['#7158e2','#3ae374', '#ff3838',"#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]);
    }
  

    public function index(Request $request){

        $grooming = DB::table('groomings')
                    ->join('orderline', 'orderline.grooming_id', '=', 'groomings.id')
                    ->join('orderinfo','orderinfo.id','=','orderline.orderinfo_id')
                    ->groupBy('groomings.description')
                    ->where('orderinfo.created_at', 'LIKE', "%". $request->datepicker ."%")
                    ->pluck(DB::raw('count(groomings.description) as total'), 'description')
                    ->all();
        // dd($grooming);
        $groomingChart = new OrderChart;
        $dataset = $groomingChart->labels(array_keys($grooming));
        $dataset= $groomingChart->dataset('Pet Groomed', 'bar', array_values($grooming));
        $dataset= $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);
        $groomingChart->options([
            
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            'aspectRatio' => 1,
            'scaleBeginAtZero' =>true,
            'scales' => [
                'yAxes'=> [[
                    'display'=>true,
                    'type'=>'linear',
                    'ticks'=> [
                        'beginAtZero'=> true,
                         'autoSkip' => true,
                         'maxTicksLimit' =>20000,
                         'min'=>0,
                        // 'max'=>20000,
                        'stepSize' => 500
                    ]],
                   'gridLines'=> ['display'=> false],
                ],
                'xAxes'=> [
                    'categoryPercentage'=> 0.8,
                    'barPercentage' => 1,
                    'gridLines' => ['display' => false],
                    'display' => true,
                    'ticks' => [
                     'beginAtZero' => true,
                     'min'=> 0,
                     'stepSize'=> 10,
                    ]
                ]
            ]
        ]);

        $condition = DB::table('conditions')
                    ->join('condition_consultation AS cc', 'cc.condition_id', '=', 'conditions.id')
                    ->join('consultations', 'consultations.id', '=', 'cc.consultation_id')
                    ->groupBy('conditions.description')
                    ->where('consultations.created_at', 'LIKE', "%". $request->datepicker ."%")
                    ->pluck(DB::raw('count(conditions.description) as total'),'description')
                    ->all();

     // $customer = asort($customer,SORT_REGULAR );
     // dd($condition);
        // dd($sales);
        $conditionChart = new ConditionChart;
     // dd(array_values($customer));
        $dataset = $conditionChart->labels(array_keys($condition));
        // dd($dataset);
        $dataset= $conditionChart->dataset('Pet Disease/Injuries', 'doughnut', array_values($condition));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);
        // dd($customerChart);
        $conditionChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            'aspectRatio' => 1,
            'scaleBeginAtZero' =>true,
            'scales' => [
                'yAxes'=> [[
                    'display'=>true,
                    'type'=>'linear',
                    'ticks'=> [
                        'beginAtZero'=> true,
                         'autoSkip' => true,
                         'maxTicksLimit' =>20000,
                         'min'=>0,
                        // 'max'=>20000,
                        'stepSize' => 500
                    ]],
                   // 'gridLines'=> ['display'=> false],
                ],
                // 'xAxes'=> [
                //     'categoryPercentage'=> 0.8,
                //     'barPercentage' => 1,
                //     'gridLines' => ['display' => false],
                //     'display' => true,
                //     'ticks' => [
                //      'beginAtZero' => true,
                //      'min'=> 0,
                //      'stepSize'=> 10,
                //     ]
                // ]
            ]
        ]);

        $pet = DB::table('pets')
            ->groupBy('pets.species')
                    ->where('pets.created_at', 'LIKE', "%". $request->datepicker ."%")
                    ->pluck(DB::raw('count(pets.species) as total'),'species')
                    ->all();

     // $customer = asort($customer,SORT_REGULAR );
     // dd($condition);
        // dd($sales);
        $petChart = new PetChart;
     // dd(array_values($customer));
        $dataset = $petChart->labels(array_keys($pet));
        // dd($dataset);
        $dataset= $petChart->dataset('Pet Number', 'pie', array_values($pet));
        // dd($customerChart);
        $dataset= $dataset->backgroundColor($this->bgcolor);
        $dataset = $dataset->fill(false);
        // dd($customerChart);
        $petChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled'=>true],
            'aspectRatio' => 1,
            'scaleBeginAtZero' =>true,
            'scales' => [
                'yAxes'=> [[
                    'display'=>true,
                    'type'=>'linear',
                    'ticks'=> [
                        'beginAtZero'=> true,
                         'autoSkip' => true,
                         'maxTicksLimit' =>20000,
                         'min'=>0,
                        // 'max'=>20000,
                        'stepSize' => 500
                    ]],
                   // 'gridLines'=> ['display'=> false],
                ],
                // 'xAxes'=> [
                //     'categoryPercentage'=> 0.8,
                //     'barPercentage' => 1,
                //     'gridLines' => ['display' => false],
                //     'display' => true,
                //     'ticks' => [
                //      'beginAtZero' => true,
                //      'min'=> 0,
                //      'stepSize'=> 10,
                //     ]
                // ]
            ]
        ]);

    return view('dashboard.index',compact('groomingChart', 'petChart', 'conditionChart'));
    
    }
}
