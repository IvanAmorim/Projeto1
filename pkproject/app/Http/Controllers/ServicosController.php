<?php

namespace App\Http\Controllers;

use App\Models\servicecategory;
use App\Models\servicexamples;
use App\Models\typeservices;
use Illuminate\Http\Request;

class ServicosController extends Controller
{
    public function index($id){
        $categories=servicecategory::orderBy('id','desc')->where('ID',$id)->paginate();
        $services=typeservices::orderBy('id','asc')->where('ID_Category',$id)->paginate();
        $ids= array();
        $cnt=0;
        foreach($services as $service){
            $ids[$cnt++]=$service->ID;
        }
        
        $examples=servicexamples::orderBy('id','asc')->whereIn('ID_TypeService',$ids)->paginate();
        
        return view('ServiceTemplate',['categories'=>$categories,'services'=>$services,'examples'=>$examples,'id'=>$id])->with('i',0);            
    }
}
