
@extends('layouts.app')
@section('links')
    <link href="/css/ServiceTemplate.css" rel="stylesheet"> 
@endsection
@section('content')
    
    <div class="title center ">
        <h1>Plataforma digital de mediação de serviços pessoais!!!</h1>
        <?php echo("<img src='/images/$id.jpg' class='image'>") ?>
        <div class="search-container center">
            <form action="/action_page.php">
            <input type="text" placeholder="Procure um serviço " name="search" class="search">
            <button type="submit" class="button">Procurar</button>
            
            </form>
        </div>
    </div>


    <div class="header">
        @foreach ($categories as $category)
        <div class="bannerservico">
            @section('titulo',$category->Name)
            <h1>{{ $category->Name }}</h1>
            <h2>{{ $category->Description }}</h2>

        </div>
        @endforeach
        <?php
            $count=0;
            
            foreach ($services as $service ){
                
                if($count % 2){

                    echo ('<div class="column side right ">'); 
                }
                else {
                    echo ('<div class="column side row left">');
                }
                echo ('<div class="examples">');
                echo ("<h3> $service->Name </h3>");
                
                foreach ($examples as $example){
                    if ($example->ID_TypeService == $service->ID){
                        $route=route("job",['id'=>$example->ID]);
                        echo("<p><a href='$route'> $example->Name </a></p>");
                    }
                }

                echo ('</div>');
                echo ('</div>');
                $count++;
            }
        ?>
    </div>
    
@endsection



