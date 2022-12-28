<?php

namespace App\Http\Controllers;

use toastr;
use App\Models\pedidos;
use App\Models\typeservices;
use Illuminate\Http\Request;
use App\Models\servicexamples;
use App\Models\servicecategory;
use App\Models\perguntaspedidos;

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
        
        return view('Pages.ServiceTemplate',['categories'=>$categories,'services'=>$services,'examples'=>$examples,'id'=>$id])->with('i',0);            
    }

    public function DataInsert(Request $request){
        
        $request->validate([
            'codPostal' => 'required',
            'email'  => 'required',
            'nomeApelido' => 'required',
            'tel' => 'required'
        ]);

        $pedido = new pedidos;
        $pedido->informacoes = $request->informacoes;
        $pedido->CodPostal = $request->codPostal;
        $pedido->Email = $request->email;
        $pedido->Nome = $request->nomeApelido;
        $pedido->Tel = $request->tel;
        $pedido->save();

        $ID=pedidos::orderBy('id','desc')->first()->ID;

        $request->validate([
            'resposta1' => 'required',
            'resposta2'  => 'required',
            'resposta3' => 'required',
            'resposta4' => 'required',
            'resposta5' => 'required'

        ]);

        $count=0;
        for($i=0;$i<=5;$i++){
            switch ($count) {
                case '0':
                    $resp="resposta1";
                    break;
                case '1':
                    $resp="resposta2";
                    break;
                case '2':
                    $resp="resposta3";
                    break;
                case '3':
                    $resp="resposta4";
                    break;
                case '4':
                    $resp="resposta5";
                    break;
            }
            $count++;
            $re=$request->$resp;
            $splittedstring=explode(",",$re);
            //Separar Id da resposta
            $ID_resposta = explode (":", $splittedstring[0]); 
            //Separar o ID da pergunta
            $ID_pergunta= explode(":",$splittedstring[1]);



            $resposta= new perguntaspedidos;
            $resposta->ID_pedido =$ID;
            $resposta->ID_pergunta=$ID_pergunta[1];
            $resposta->ID_resposta=$ID_resposta[1];
            $resposta->save();
        }
        // Display an error toast with no title
    
        return back()->with('success','O Pedido foi adicionado com sucesso!');
  
    
    }

    public function prestadores(){
        return view('Pages.prestadores');
        
    }

    public function user(){
        return view('Pages.userpedidos');
    }

}
