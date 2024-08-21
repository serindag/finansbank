@extends('layouts.app')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets') }}/datatable/css/jquery.dataTables.css">
    @endpush

    @push('scripts')
        <script type="text/javascript" language="javascript" src="{{ asset('assets') }}/datatable/js/jquery-3.5.1.js"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('assets') }}/datatable/js/jquery.dataTables.js">
        </script>
        <script type="text/javascript" language="javascript" src="{{ asset('assets') }}/datatable/js/tr.js"></script>
    @endpush

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table id="datatable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>İsim Soyisim</th>
                            <th>Telefon</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $data->order_id }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->phone }}</td>
                                <td>{{ $data->price }} ₺</td>
                                <td>
                                    @if ($data->stats == 0)
                                        <button class="btn btn-sm btn-danger">Başarısız</button>
                                    @else
                                        <button class="btn btn-sm btn-success">Başarılı</button>
                                    @endif
                                <td>
                                    {{ Carbon::parse($data->created_at)->translatedFormat('d/m/Y') }}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>İsim Soyisim</th>
                            <th>Telefon</th>
                            <th>Fiyat</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
