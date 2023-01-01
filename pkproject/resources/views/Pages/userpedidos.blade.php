@extends('layouts.app')
@section('content')



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Os meus pedidos</div>

                    <table class="table table-striped text-center">
                        <tr>
                            <td>Tipo</td>
                            <td>Serviço</td>
                            <td>Propostas</td>
                        </tr>
                        <?php $i=0;?>
                        @foreach ($results as $result )
                            <tr>
                                <td>{{ $result->NameType}}</td>
                                <td>{{ $result->NameService}}</td>
                                <td>{{ $propostas[$i]}} <a href="{{ route('Pages.verpropostas',['id'=> $result->IDPedido]) }}" class="btn btn-primary ms-2">Ver</a></td>
                            </tr>
                            <?php $i++;?>    
                        @endforeach
                    
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

