@extends('layouts.app')

@section('content')
    <div class="header bg-gradient-primary pb-6 pt-5">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Veículos</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                      <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a class="text-red" href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a class="text-red" href="{{route('veiculos')}}">Veículos</a></li>
                        <li class="breadcrumb-item"><a class="text-red" href="#">@if(isset($veiculo->id)) Editar @else Novo @endif</a></li>
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
                <h3 class="mb-0">@if(isset($veiculo->id)) Editar @else Novo @endif Veículo</h3>
                </div>

                @if(isset($veiculo->id))
                <input type="hidden" value="{{$veiculo->id}}" id="id">
                @endif

                <div class="pl-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="placa">Placa</label>
                        <input type="text" name="placa" id="placa" class="form-control form-control-alternative" placeholder="Placa" value="{{isset($veiculo->placa) ? $veiculo->placa : ""}}" autofocus="">
                    </div>

                    <div class="form-group focused">
                        <label class="form-control-label" for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control form-control-alternative" placeholder="Modelo" value="{{isset($veiculo->modelo) ? $veiculo->modelo : ""}}" autofocus="">
                    </div>

                    <div class="form-group focused">
                        <label class="form-control-label" for="cor">Cor</label>
                        <input type="text" name="cor" id="cor" class="form-control form-control-alternative" placeholder="Cor" value="{{isset($veiculo->cor) ? $veiculo->cor : ""}}" autofocus="">
                    </div>

                    <div class="form-group focused">
                        <label class="form-control-label" for="tipo">Tipo</label>
                        <select class="form-control form-control-alternative" id="tipo">
                            <option value="">Selecione</option>
                            <option @if(isset($veiculo->tipo) && $veiculo->tipo == "Carro") selected @endif>Carro</option>
                            <option @if(isset($veiculo->tipo) && $veiculo->tipo == "Moto") selected @endif>Moto</option>
                          </select>
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
    <script src="{{ asset('assets/js/jquery.mask.js') }}"></script>

    <script>
        /* $("#placa").mask("SSS0A00"); */
        $('#placa').mask('SSS0A00', {
                    'translation': {
                        S: {pattern: /[A-Za-z]/},
                        0: {pattern: /[0-9]/}
                    }
                    ,onKeyPress: function (value, event) {
                        event.currentTarget.value = value.toUpperCase();
                    }
        });

        /* $('#placa').mask('SSS0000'); */

        $( document ).ready(function() {
            $('#salvar').on('click', function(){
                var veiculo_id = $('#id').val();
                var placa = $('#placa').val();
                var modelo = $('#modelo').val();
                var cor = $('#cor').val();
                var tipo = $('#tipo').val();
                var token = "{{csrf_token()}}";

                if(placa == ""){
                    toastr.info('O campo "placa" não pode estar vazio.');
                    return;
                }

                if(modelo == ""){
                    toastr.info('O campo "modelo" não pode estar vazio.');
                    return;
                }

                if(cor == ""){
                    toastr.info('O campo "cor" não pode estar vazio.');
                    return;
                }

                if(tipo == ""){
                    toastr.info('Você precisa selecionar alguma opção no campo "tipo".');
                    return;
                }

                $.post( "{{route('veiculos.store')}}", { veiculo_id: veiculo_id, placa: placa, modelo: modelo, cor: cor, tipo: tipo, _token: token })
                .done(function( data ) {
                    if(data.status == 'success'){
                        toastr.success(data.msg, "Sucesso", {
                            timeOut: 1000,
                            preventDuplicates: true,
                            // Redirect 
                            onHidden: function() {
                                window.location.href = '/veiculos';
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