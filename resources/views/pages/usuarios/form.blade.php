@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-6 pt-5">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Usuários</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a class="text-red" href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a class="text-red" href="{{route('usuarios')}}">Usuários</a></li>
                        <li class="breadcrumb-item"><a class="text-red" href="#">@if(isset($usuario->id)) Editar @else Novo @endif</a></li>
                      </ol>
                    </nav>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
          <div class="col">
            <div class="card">
              <!-- Card header -->
                <div class="card-header border-0">
                <h3 class="mb-0">@if(isset($usuario->id)) Editar @else Novo @endif Usuário</h3>
                </div>

                @if(isset($usuario->id))
                <input type="hidden" value="{{$usuario->id}}" id="id">
                @endif

                <div class="pl-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="input-name">Nome</label>
                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Nome" value="{{isset($usuario->name) ? $usuario->name : ""}}" autofocus="">
                    </div>

                    <div class="form-group focused">
                        <label class="form-control-label" for="input-email">Email</label>
                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative" placeholder="Email" value="{{isset($usuario->email) ? $usuario->email : ""}}">
                    </div>

                    <div class="form-group focused">
                        <label class="form-control-label" for="input-senha">Senha</label>
                        <input type="password" name="senha" id="input-senha" class="form-control form-control-alternative" placeholder="Senha">
                    </div>

                <div class="text-center mb-4">
                    <a href="javascript:void(0)" id="salvar" class="btn btn-success">Salvar</a>
                    <a href="{{route('usuarios')}}" class="btn btn-danger">Cancelar</a>
                </div>
                </div>
              <!-- Light table -->
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

    <script>
        $( document ).ready(function() {
            $('#salvar').on('click', function(){
                var user_id = $('#id').val();
                var name = $('#input-name').val();
                var email = $('#input-email').val();
                var password = $('#input-senha').val();
                var token = "{{csrf_token()}}";

                if(name == ""){
                    toastr.info('O campo "nome" não pode estar vazio.');
                    return;
                }

                if(email == ""){
                    toastr.info('O campo "email" não pode estar vazio.');
                    return;
                }

                if(password == "" && user_id == ""){
                    toastr.info('O campo "senha" não pode estar vazio.');
                    return;
                }

                $.post( "{{route('usuarios.store')}}", { user_id: user_id, name: name, email: email, password: password, _token: token })
                .done(function( data ) {
                    if(data.status == 'success'){
                        toastr.success(data.msg, "Sucesso", {
                            timeOut: 1000,
                            preventDuplicates: true,
                            // Redirect 
                            onHidden: function() {
                                window.location.href = '/usuarios';
                            }
                        });
                    } else {
                        toastr.error(data.msg);
                    }
                });
            });
        });
    </script>
@endpush