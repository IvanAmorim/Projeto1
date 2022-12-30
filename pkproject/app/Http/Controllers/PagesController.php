<?php

namespace App\Http\Controllers;

use App\Models\perguntas;
use App\Models\respostas;
use App\Models\servicexamples;
use App\Models\typeservices;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $search = request('search');
        if($search){
            $count=typeservices::orderBy('typeservices.id')
                                                            ->leftjoin('servicexamples','typeservices.ID','=','servicexamples.ID_TypeService')
                                                            ->leftjoin('servicecategories','typeservices.ID_Category','=','servicecategories.ID')                                            
                                                            ->select('typeservices.Name AS NameType','servicexamples.Name AS NameService','Servicecategories.ID AS CategoryID')
                                                            ->where( [['servicexamples.Name', 'like', '%'.$search.'%']])
                                                            ->count();
            if($count!=0){
                $results=typeservices::orderBy('typeservices.id')
                                                            ->leftjoin('servicexamples','typeservices.ID','=','servicexamples.ID_TypeService')
                                                            ->leftjoin('servicecategories','typeservices.ID_Category','=','servicecategories.ID')                                            
                                                            ->select('typeservices.Name AS NameType','servicexamples.Name AS NameService','Servicecategories.ID AS CategoryID')
                                                            ->where( [['servicexamples.Name', 'like', '%'.$search.'%']])
                                                            ->get();
                foreach($results as $result){
                  return redirect(route('service', ['id' => $result->CategoryID])) ;
                    
   
                }
            }else{
                return redirect()->back()->with('error', 'Não existe');  
            }
        }
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
