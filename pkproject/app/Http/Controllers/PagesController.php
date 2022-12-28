<?php

namespace App\Http\Controllers;

use App\Models\perguntas;
use App\Models\respostas;
use App\Models\servicexamples;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('Pages.MainPage');
    }

    public function main(){
        return view('Pages.MainPage');
    }

    public function service(){
        return view('ServiceTemplate');
    }
    public function job($id){
        $perguntas=perguntas::orderBy('id','asc')->where('ID_serviceexamples',$id)->paginate();
        $ids=array();
        $cnt=0;
        foreach($perguntas as $pergunta){
            $ids[$cnt++]=$pergunta->ID;
        }
       
        $count=respostas::orderBy('id','asc')->whereIn('ID_pergunta',$ids)->count();
        $respostas=respostas::orderBy('id','asc')->whereIn('ID_pergunta',$ids)->paginate($count);
        $categoria= servicexamples::orderBy('id')->where('ID',$id)->value('Name');
        
        return view('job',['perguntas'=>$perguntas,'respostas'=>$respostas,'categoria'=>$categoria, 'id'=>$id]);
    }

}
