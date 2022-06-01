@extends('layouts.master')
@section('content')
<div class="col-md-9 well well-md">
    <center><h1>Profil</h1></center>
    {!! Form::open(['url' => 'validerManga', 'files' => true]) !!} 
    {{ csrf_field() }}
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-3 ">
               {{Form::text("Nom", old("nom") ? old("nom"): (!empty($manga) ? $manga->nom : null),
                            [ "class" => "form-control", "placeholder" => "Nom", "required", "autofocus"])
                }}                   
            </div>
           @error('nom')
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
           @enderror          
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label">Prénom : </label>
            <div class="col-md-3 ">
		 {{Form::text("Prenom", old("prenom") ? old("prenom"): (!empty($manga) ? $manga->prenom : null),
                            [ "class" => "form-control", "placeholder" => "Prenom", "required", "autofocus"])
                }}
            </div>
            @error('prenom')
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
           @enderror           
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Rue : </label>
            <div class="col-md-5 ">
                 {{Form::text("Rue", old("rue") ? old("rue"): (!empty($manga) ? $manga->Rue : null),
                            [ "class" => "form-control", "placeholder" => "Rue", "required", "autofocus"])
                }}
                 @error('rue')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                 @enderror                
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Code postal : </label>
            <div class="col-md-2">
                {{Form::text("Code", old("code") ? old("code"): (!empty($manga) ? $manga->Code : null),
                            [ "class" => "form-control", "placeholder" => "code", "required", "autofocus"])
                }}
            </div>
             @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
           @enderror 
        </div>       
        <div class="form-group">
            <label class="col-md-3 control-label">Ville : </label>
            <div class="col-md-3 ">
                {{Form::text("Ville", old("ville") ? old("ville"): (!empty($manga) ? $manga->ville : null),
                            [ "class" => "form-control", "placeholder" => "ville", "required", "autofocus"])
                }}
                </div>
                @error('ville')
                <span class="invalid-feedback" role="alert">
                    <strong>{{$message}}</strong>
                </span>
                 @enderror
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-3 ">
                {{Form::text("role", $user->role,
                            ["class" => "form-control", "readyonly"])
                }}
            </div>
        </div>          
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>     
                &nbsp;
                <button type="button" class="btn btn-default btn-primary" 
                    onclick="javascript: window.location = '{{ url('/') }}';">
                    <span class="glyphicon glyphicon-remove"></span> Annuler
                </button>                
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop
