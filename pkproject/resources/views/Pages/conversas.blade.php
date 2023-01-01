@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card-group mt-5">
                    <div class="card">
                      <div class="card-body text-center">
                        <h5 class="card-title text-center">{{ $pedidos[0]->Nome }}</h5>
                        <p class="card-text fw-light">{{ $pedidos[0]->CodPostal }},{{ $pedidos[0]->Concelho }}<br>{{ $pedidos[0]->Tel }}</p>
                        <p class="card-text">{{ $pedidos[0]->Name }}</p>
                        <div class="text-start">
                            @foreach ($perguntas as $pergunta)
                                <p class="card-text"><small class="text-muted">{{ $pergunta->Pergunta }}</small><br>{{ $pergunta->Resposta }}</p>

                            @endforeach
                        </div>

                        @if(Auth::user()->tipo!=1 && $estado=="Em aprovação")
                            <form action="/Pages/conversas/{{ $id }}/estado" method="post" enctype="multipart/form-data">
                                @csrf
                               
                                <div class="mt-4">
                                    <button class="btn btn-success" type="submit" name="aprovar" value="Aprovado">Aprovar</button>
                                    <button class="btn btn-danger" type="submit" name="aprovar" value="Reprovado">Reprovar</button>
                                </div>
                            </form>
                        @endif
                        <p class="card-text text-end"><small class="text-muted">{{ $pedidos[0]->created_at }}</small></p>
                        
                        <!--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-center mt-5">Proposta</h5>

                        <div class="card-body text-center">
                            <h5 class="card-title text-center">{{ $proposta[0]->name }}</h5>
                            <p class="card-text fw-light">{{ $proposta[0]->email }}</p>
                            <p class="card-text">{{ $proposta[0]->Valor }}€ <br><?php if($proposta[0]->Tipo == 1) echo(" Preço fixo (€)"); else echo("Preço por hora(€/h)");?></p>
                        
                            @switch($estado)
                                @case("Aprovado")
                                    <p class="card-text mt-1 text-success">Estado da proposta: {{ $estado }}</p>
                                    @break
                                @case("Reprovado")
                                    <p class="card-text mt-1 text-danger">Estado da proposta: {{ $estado }}</p>
                                    @break  
                                @default
                                    <p class="card-text mt-1">Estado da proposta: {{ $estado }}</p>
                                    @break
                            @endswitch
                        </div>
                        
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title text-center mt-5">Conversa</h5>
  
                            <div class="card-body">
                                @foreach ($mensagens as $mensagem)
                                    @if($mensagem->ID_user==Auth::user()->id)
                                        <div class="text-end">
                                    @else
                                        <div class="text-left">
                                    @endif
                                        <p>{{ $mensagem->Mensagem }}</p>
                                        </div>
                                @endforeach
                            </div>
                          
                          <form action="/Pages/conversas/{{ $id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="mensagem" placeholder="Mensagem" aria-label="Recipient's username" aria-describedby="button-addon2" required>
                                    <button class="btn btn-outline-secondary" type="submit">Enviar</button>
                                </div>
                                


                              

                        </form>
  
                          
                        </div>
                      </div>
                    
                 
           
                </div>
            </div>
        </div>
    </div>

@endsection