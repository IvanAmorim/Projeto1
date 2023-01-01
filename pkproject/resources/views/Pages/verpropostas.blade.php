@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-15">
            <div class="card">
                <div class="card-header">Prestadores</div>

                <table class="table table-striped text-center ">
                    <tr>
                        @if (Auth::user()->tipo!=1)
                            <td>Nome do prestador</td>
                            <td>Email</td>
                        @else
                            <td>Nome do cliente</td>
                            <td>Email</td>
                        @endif
                        
                        <td>Preço</td>
                        <td>Mensagem</td>
                        <td>Estado da proposta</td>
                        <td></td>

                    </tr>
                    <?php $i=0;?>
                    @foreach ($propostas as $proposta )
                        <tr>
                            <td>{{ $proposta->name}} </td>
                            <td>{{ $proposta->email}}</td>
                            <td>{{ $proposta->Valor }}€ <?php if($proposta->Tipo == 1) echo(" Preço fixo (€)"); else echo("Preço por hora(€/h)");?></td>
                            <td>{{ $proposta->Mensagem }}</td>
                            <td>{{ $estado[$i] }}</td>
                            <td><a href="{{ route('Pages.conversas',['id'=>$proposta->ID]) }}" class="btn btn-primary ms-2">Detalhes</a></td>
                        </tr>
                        <?php $i++;?>    
                    @endforeach
                
                </table>
            </div>
        </div>
    </div>
</div>


@endsection