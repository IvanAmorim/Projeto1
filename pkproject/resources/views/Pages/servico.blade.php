@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group mt-5">
                    <div class="card">
                      <div class="card-body text-center">
                        @if( $perguntas[0] == Null )
                        <h5 class="card-title text-center">{{ $pedidos[0]->Nome }}</h5>
                        <p class="card-text fw-light">{{ $pedidos[0]->CodPostal }},{{ $pedidos[0]->Concelho }}<br>{{ $pedidos[0]->Tel }}</p>
                        <p class="card-text">{{ $pedidos[0]->Name }}</p>
                        <div class="text-start">
                          <p class="card-text"><small class="text-muted">Nome:</small><br>{{ $pedidos[0]->Nomeservico }}</p>
                          <p class="card-text"><small class="text-muted">Descrição:</small><br>{{$pedidos[0]->informacoes }}<br></p>
                        </div>
                        <p class="card-text text-end"><small class="text-muted">{{ $pedidos[0]->created_at }}</small></p>
                        
                        @else
                        
                        <h5 class="card-title text-center">{{ $pedidos[0]->Nome }}</h5>
                        <p class="card-text fw-light">{{ $pedidos[0]->CodPostal }},{{ $pedidos[0]->Concelho }}<br>{{ $pedidos[0]->Tel }}</p>
                        <p class="card-text">{{ $pedidos[0]->Name }}</p>
                        <div class="text-start">
                            @foreach ($perguntas as $pergunta)
                                <p class="card-text"><small class="text-muted">{{ $pergunta->Pergunta }}</small><br>{{ $pergunta->Resposta }}</p>

                            @endforeach
                        </div>
                        <p class="card-text text-start pt-3"><small class="text-muted">Mais informações:</small><br>{{$pedidos[0]->informacoes }}</p>
                        <p class="card-text text-end"><small class="text-muted">{{ $pedidos[0]->created_at }}</small></p>
                        @endif
                        <!--<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>-->
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-center mt-5">Fazer proposta</h5>

                        <form action="servico" method="POST" enctype="multipart/form-data">     
                            @csrf                   
                            <p class="card-text mt-5">Que preço leva por este serviço?</p>
                            <input class="form-control fs-3" type="number"  name="valor" step="0.01" placeholder="0.00€" aria-label="default input example" style="background-color:#E5E3E2" required>
                            <select class="block-header form-control text-center btn btn-secondary btn-lg " name="tipo">
                                <option value='1'> Preço fixo (€) </option>
                                <option value='2'> Preço por hora(€/h) </option>
                            </select>

                            <p class="card-text mt-5">Mensagem a {{ $pedidos[0]->Nome }}</p>
                            <div class="mb-3">
                                <textarea class="form-control" name="mensagem" rows="3" placeholder="Apresente-se, deixe uma mensagem personalizada, criativa e mostre ao cliente que é o especialista certo para este projeto." style="background-color:#E5E3E2"></textarea>
                              </div>

                              <button type="submit" class="btn btn-secondary form-control mt-5" name="id" value="{{ $pedidos[0]->ID }}"> Enviar proposta (2 créditos)</button>
                              <p class="text-center pt-2">Os meus créditos: {{ $creditos }}</p>
                        </form>

                        
                      </div>
                    </div>
                 
           
                </div>
            </div>
        </div>
    </div>

@endsection