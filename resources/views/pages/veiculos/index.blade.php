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
                      </ol>
                    </nav>
                  </div>
                  <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('veiculos.novo')}}" class="btn btn-sm btn-neutral text-red">Novo veículo</a>
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
                <h3 class="mb-0">Listagem de veículos</h3>
              </div>
              <!-- Light table -->
              <div class="table-responsive">
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="sort" data-sort="name">Placa</th>
                      <th scope="col" class="sort" data-sort="budget">Modelo</th>
                      <th scope="col" class="sort" data-sort="budget">Cor</th>
                      <th scope="col" class="sort" data-sort="budget">Tipo</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="list">
                        @forelse($veiculos as $dados)
                        <tr>
                            <th scope="row">
                              <div class="media align-items-center">
                                <div class="media-body">
                                  <span class="name mb-0 text-sm">
                                      {{$dados->placa}}
                                  </span>
                                </div>
                              </div>
                            </th>
                            <td class="budget">
                              {{$dados->modelo}}
                            </td>
                            <td class="budget">
                                {{$dados->cor}}
                              </td>
                              <td class="budget">
                                {{$dados->tipo}}
                              </td>
                            <td class="text-right">
                                @if(auth()->user()->id == $dados->usuario_id)
                                    <a href="{{route('veiculos.edit', [$dados->id])}}" class="text-red" data-toggle="tooltip" data-original-title="Editar">
                                        <i class="fa fa-edit fa-2x"></i>
                                    </a>
                                    <a href="#" onclick="excluirVeiculo({{$dados->id}})" class="text-red" data-toggle="tooltip" data-original-title="Excluir">
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

    <script>
        function excluirVeiculo(id){
            $.confirm({
            title: 'Excluir registro',
            content: 'Tem certeza que deseja excluir o veículo?',
            buttons:{
                excluir: function(){
                    var token = "{{csrf_token()}}";
                    $.post( "{{route('veiculos.delete')}}", { id: id, _token: token })
                        .done(function( data ) {
                            if(data.status == 'success'){
                                toastr.success(data.msg, "Sucesso", {
                                    timeOut: 1000,
                                    preventDuplicates: true,
                                    // Redirect 
                                    onHidden: function() {
                                        location.reload();
                                    }
                                });
                            } else {
                                toastr.error(data.msg);
                            }
                        });
                },
                cancelar: function(){
                },
            }
        });
        }
    </script>
@endpush