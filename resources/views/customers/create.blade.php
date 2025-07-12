@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" />
@endsection
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <form method="POST" action="{{ url('/customers') }}" id="customerForm">
            @csrf
            <div class="mb-3">
                <label for="CstName" class="form-label">Nama</label>
                <input type="text" class="form-control" id="CstName" name="CstName" placeholder="Masukan nama anda" required>
            </div>
            <div class="mb-3">
                <label for="CstDob" class="form-label">Tanggal Lahir</label>
                <div class="input-group date" id="datepicker">
                    <input type="text" class="form-control" id="CstDob" name="CstDob" placeholder="Masukan tanggal lahir" required>
                    <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <label for="NationalityID" class="form-label">Kewarganegaraan</label>
                <select class="form-select" id="NationalityID" name="NationalityID" required>
                    <option value="">Pilih kewarganegaraan</option>
                    @foreach($nationalities as $nation)
                        <option value="{{ $nation['NationalityID'] }}">
                            {{ $nation['NationalityName'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <span>
                    <h4>Keluarga </h4>
                </span>
                <span>
                    <button type="button" id="addFamily" class="btn btn-dark btn-sm"><i class="fa fa-plus"></i> Tambah Keluarga</button>
                </span>
            </div>

            <div id="familyContainer">
                <div class="row mb-2 family-item">
                    <div class="col-md-5">
                        <input type="text" name="Family[0][FlName]" class="form-control" placeholder="Masukan Nama" required>
                    </div>
                    <div class="col-md-6">
                        <input type="date" name="Family[0][FlDob]" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger w-100 removeFamily">Hapus</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Simpan</button>
        </form>
    </div>
</main>
@endsection
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    let familyIndex = 1;
    document.getElementById('addFamily').addEventListener('click', function() {
        const container = document.getElementById('familyContainer');
        const div = document.createElement('div');
        div.className = 'row mb-2 family-item';
        div.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="Family[${familyIndex}][FlName]" class="form-control" placeholder="Masukan Nama" required>
            </div>
            <div class="col-md-6">
                <input type="date" name="Family[${familyIndex}][FlDob]" class="form-control" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger w-100 removeFamily">Hapus</button>
            </div>
        `;
        container.appendChild(div);
        familyIndex++;
    });

    document.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('removeFamily')){
            e.target.closest('.family-item').remove();
        }
    });

    $(function(){
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd', // Format Y-m-d
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
@endsection
