<?php

namespace App\Http\Controllers;

use toastr;
use App\Models\pedidos;
use App\Models\perguntas;
use App\Models\respostas;
use App\Models\typeservices;
use Illuminate\Http\Request;
use App\Models\pedidoservicos;
use App\Models\servicexamples;
use App\Models\servicecategory;
use App\Models\perguntaspedidos;
use Illuminate\Support\Facades\Auth;

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
        $res=$request->except('_token');
       
        $pedido = new pedidos;
        $pedido->ID_user=Auth::user()->id;
        $pedido->informacoes = $request->informacoes;
        $pedido->CodPostal = $request->codPostal;
        $pedido->Email = $request->email;
        $pedido->Nome = $request->nomeApelido;
        $pedido->Tel = $request->tel;
        $pedido->save();

        
        $ID=pedidos::orderBy('id','desc')->first()->ID;

        $resp="resposta";

        $perguntas=perguntas::orderBy('id','asc')->where('ID_serviceexamples',$request->id)->paginate();
        $i=0;
        foreach ($perguntas as $pergunta){
            $r=$resp.$i;
            if($pergunta->tipo_resposta==2){
                $resposta= new perguntaspedidos;
                $resposta->ID_pedido =$ID;
                $resposta->ID_pergunta=$pergunta->ID;
                $resposta->ID_resposta=$res[$r];
                $resposta->save();
            }else{
                //guarda a resposta
                $resposta= new respostas;
                $resposta->ID_pergunta=$pergunta->ID;
                $resposta->Resposta=$res[$r];
                $resposta->save();
                //guarda no pedido
                $idResposta=respostas::orderBy('id','desc')->first()->ID;
                $resposta= new perguntaspedidos;
                $resposta->ID_pedido =$ID;
                $resposta->ID_pergunta=$pergunta->ID;
                $resposta->ID_resposta=$idResposta;
                $resposta->save();
            }
            $i++;
        }
        
        $pedidoservico= new pedidoservicos;
        $pedidoservico->ID_pedido=$ID;
        $pedidoservico->ID_servico=$pergunta->ID_serviceexamples;
        $pedidoservico->ID_user=Auth::user()->id;
        $pedidoservico->save();

        

        // Display an error toast with no title
    
        return view('Pages.MainPage')->with('success','O Pedido foi adicionado com sucesso!');
    }

    public function prestadores(){
        return view('Pages.prestadores');
        
    }

    public function user(){
        $user=Auth::user()->id;
        $result=servicexamples::orderBy('servicexamples.id')
                                            ->leftjoin('typeservices','servicexamples.ID_TypeService','=','typeservices.ID')
                                            ->leftjoin('pedidoservicos','pedidoservicos.ID_servico','=','servicexamples.ID')                                            
                                            ->select('servicexamples.Name AS NameService','typeservices.Name AS NameType','pedidoservicos.ID_user AS userID')
                                            ->where('pedidoservicos.ID_user',$user)
                                            ->paginate();  
        return view('Pages.userpedidos',['results'=>$result]);
    }

    public function categoria(){
        $categorias=servicecategory::orderBy('id')->paginate();
        return view('Admin.categoria',['categorias'=>$categorias]);
    }

    public function servicos(){
        $servicos=typeservices::orderBy('id')->paginate();
        return view('Admin.servico',['servicos'=>$servicos]);
    }

    //Inserir categoria
    public function categoryinsert(Request $request){
        $categoria= new typeservices;
        $categoria->ID_Category=$request->categoria;
        $categoria->Name=$request->nome;
        $categoria->save();
        return view('home');
      
    }

    public function servicoinsert(Request $request){
        $servico = new servicexamples;
        $servico->ID_TypeService=$request->categoria;
        $servico->Name=$request->nome;
        $servico->save();
        
        $name=servicexamples::orderBy('id','desc')->first()->Name;
        return view('Admin.perguntas',['name'=>$name]);
    }

    public function perguntas(){
        $name=servicexamples::orderBy('id','desc')->first()->Name;
        return view('Admin.perguntas',['name'=>$name]);

        
    }

    public function perguntasInsert(Request $request){
        $id=servicexamples::orderBy('id','desc')->first()->ID; 

        switch($request->tipo){
            case '3':
                $tipo=2;
                break;
            default:
                $tipo=1;
                break;
        }
        $pergunta = new perguntas;
        $pergunta->ID_serviceexamples=$id;
        $pergunta->Pergunta=$request->pergunta;
        $pergunta->tipo_resposta=$tipo;
        $pergunta->save();

        //tipo - 1 = texto
        //tipo - 2 = texto mais=nao
        //tipo - 3 = e.multipla


       if($request->tipo==1 ){
            $name=servicexamples::orderBy('id','desc')->first()->Name;
            return view('Admin.perguntas',['name'=>$name]);
       }else if($request->tipo==3){
            return view('Admin.respostas',['pergunta'=>$request->pergunta]);
       }else{
            return view('home');
       }
    }

    public function respostasInsert(Request $request){
        $id=perguntas::orderBy('id','desc')->first()->ID;
        $resposta= new respostas;
        $resposta->ID_pergunta=$id;
        $resposta->Resposta=$request->resposta;
        $resposta->save();
//2-sim
//3-nao
        if($request->mais==3){
            $pergunta=perguntas::orderBy('id','desc')->first()->Pergunta;
            return view('Admin.respostas',['pergunta'=>$pergunta]);
        }
        else if($request->mais==1) {
            $name=servicexamples::orderBy('id','desc')->first()->Name;
            return view('Admin.perguntas',['name'=>$name]);
        }else{
            return view('home');
        }

    }

}
