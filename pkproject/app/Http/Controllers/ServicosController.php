<?php

namespace App\Http\Controllers;

use App\Models\estadoproposta;
use App\Models\estadopropostas;
use App\Models\mensagens;
use toastr;
use App\Models\pedidos;
use App\Models\perguntas;
use App\Models\propostas;
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
        $pedido->Concelho = $request->Concelho;
        $pedido->Lugar = $request->Lugar;
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
        $result=pedidoservicos::orderBy('pedidoservicos.id')
                                                            ->leftjoin('servicexamples','pedidoservicos.ID_servico','=','servicexamples.ID')
                                                            ->leftjoin('users','pedidoservicos.ID_user','=','users.id')
                                                            ->leftjoin('pedidos','pedidoservicos.ID_pedido','=','pedidos.ID')
                                                            ->paginate();
        /*foreach($result as $res){
            echo("<br>");
            print_r($res);
        }*/
        return view('Pages.prestadores',['results'=>$result]);
        
    }

    public function user(){
        $user=Auth::user()->id;
        $result=servicexamples::orderBy('servicexamples.id')
                                            ->leftjoin('typeservices','servicexamples.ID_TypeService','=','typeservices.ID')
                                            ->leftjoin('pedidoservicos','pedidoservicos.ID_servico','=','servicexamples.ID')                                          
                                            ->select('servicexamples.Name AS NameService','typeservices.Name AS NameType','pedidoservicos.ID_user AS userID','pedidoservicos.ID_pedido AS IDPedido')
                                            ->where('pedidoservicos.ID_user',$user)
                                            ->paginate();  
        $i=0;
        foreach($result as $r ){
            $count[$i]=propostas::orderBy('id')->where('ID_pedido',$r->IDPedido)->count();
            $i++;
        }
       if($i==0)
        return redirect()->back()->with('error','Ainda não tem nenhum pedido');
        
        return view('Pages.userpedidos',['results'=>$result,'propostas'=>$count]);
    }

    public function categoria(){
        $categorias=servicecategory::orderBy('id')->paginate();
        return view('Admin.categoria',['categorias'=>$categorias]);
    }

    public function servicos(){
        $count=typeservices::orderBy('id')->count();
        $servicos=typeservices::orderBy('id')->paginate($count);
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


    public function servico($id){

        $pedidos=pedidoservicos::orderBy('pedidoservicos.id')
                                                            ->leftjoin('servicexamples','pedidoservicos.ID_servico','=','servicexamples.ID')
                                                            ->leftjoin('pedidos','pedidoservicos.ID_pedido','=','pedidos.ID')
                                                            ->where('pedidos.id',$id)
                                                            ->get();                                       
                                                            
        $perguntas=perguntaspedidos::orderBy('perguntaspedidos.id')
                                                                ->leftjoin('respostas','perguntaspedidos.ID_resposta','=','respostas.ID')
                                                                ->leftjoin('perguntas','perguntaspedidos.ID_pergunta','=','perguntas.ID')
                                                                ->where('perguntaspedidos.ID_pedido',$id)
                                                                ->select('perguntas.Pergunta','respostas.Resposta')
                                                                ->paginate();

        return view('Pages.servico',['pedidos'=>$pedidos,'perguntas'=>$perguntas]);
    }

    public function propostainsert(Request $request){
        $id=Auth::user()->id;

        $proposta = new propostas;
        $proposta->ID_pedido=$request->id;
        $proposta->ID_prestador=$id;
        $proposta->Valor=$request->valor;
        $proposta->Tipo=$request->tipo;
        $proposta->Mensagem=$request->mensagem;
        $proposta->save();    

        $result=pedidoservicos::orderBy('pedidoservicos.id')
        ->leftjoin('servicexamples','pedidoservicos.ID_servico','=','servicexamples.ID')
        ->leftjoin('users','pedidoservicos.ID_user','=','users.id')
        ->leftjoin('pedidos','pedidoservicos.ID_pedido','=','pedidos.ID')
        ->paginate();


        return view('Pages.prestadores',['results'=>$result])->with('success','A proposta foi adicionada com sucesso!');

    }

    public function verproposta($id){
        if($id=="all"){
            $id=Auth::user()->id;
            $propostas=propostas::orderBy('ID')
                                        ->leftjoin('pedidos','pedidos.ID','=','propostas.ID_pedido')
                                        ->leftjoin('users','users.id','=','pedidos.ID_user')
                                        ->select('propostas.*','users.name','users.email')
                                        ->where('ID_prestador',$id)->paginate();
        }else{
               $propostas=propostas::orderBy('ID')
                                        ->leftjoin('users','propostas.ID_prestador','=','users.id')
                                        ->select('propostas.*','users.name','users.email')
                                        ->where('ID_pedido',$id)
                                        ->paginate();
        }
        
        $i=0;
        foreach($propostas as $proposta){
            $cnt=estadopropostas::orderBy('ID')->where('ID_proposta',$proposta->ID)->count();
            if( $cnt == 0  ) {
                $estado[$i]="Em aprovação";
            }else{
                $estados=estadopropostas::orderBy('ID')->where('ID_proposta',$proposta->ID)->get();
                $estado[$i]=$estados[0]->estado;
            }
            $i++;
        }
        


        return view('Pages.verpropostas',['propostas'=>$propostas,'estado'=>$estado]);
    }

    public function conversas($id){
        $proposta=propostas::orderBy('ID')
                                        ->leftjoin('users','propostas.ID_prestador','=','users.id')
                                        ->where('propostas.ID',$id)
                                        ->select('propostas.*','users.name','users.email')
                                        ->get();
    

        $pedidos=pedidoservicos::orderBy('pedidoservicos.id')
                                                            ->leftjoin('servicexamples','pedidoservicos.ID_servico','=','servicexamples.ID')
                                                            ->leftjoin('pedidos','pedidoservicos.ID_pedido','=','pedidos.ID')
                                                            ->where('pedidos.id',$proposta[0]->ID_pedido)
                                                            ->get();                                      
                                                            
        $perguntas=perguntaspedidos::orderBy('perguntaspedidos.id')
                                                                ->leftjoin('respostas','perguntaspedidos.ID_resposta','=','respostas.ID')
                                                                ->leftjoin('perguntas','perguntaspedidos.ID_pergunta','=','perguntas.ID')
                                                                ->where('perguntaspedidos.ID_pedido',$proposta[0]->ID_pedido)
                                                                ->select('perguntas.Pergunta','respostas.Resposta')
                                                                ->paginate();

        $mensagem=mensagens::orderBy('ID')->where('ID_proposta',$id)->paginate();

        $estado=estadopropostas::orderBy('ID')->where('ID_proposta',$id)->count();
        if( $estado == 0  ) {
            $estado="Em aprovação";
        }else{
            $estados=estadopropostas::orderBy('ID')->where('ID_proposta',$id)->get();
            $estado=$estados[0]->estado;
        }

        return view('Pages.conversas',['pedidos'=>$pedidos,'perguntas'=>$perguntas,'proposta'=>$proposta,'id'=>$id, 'mensagens'=>$mensagem,'estado'=>$estado ]);
    }

    public function conversassubmit($id, Request $request){
        $i=Auth::user()->id;

        $mensagem = new mensagens;
        $mensagem->ID_user=$i;
        $mensagem->ID_proposta=$id;
        $mensagem->Mensagem=$request->mensagem;
        $mensagem->save();

        return redirect()->back();
    }
    public function estado($id, Request $request){
       
        $estado = new estadopropostas;
        $estado->ID_proposta=$id;
        $estado->estado=$request->aprovar;
        $estado->save();

        return redirect()->back();
    }






}
