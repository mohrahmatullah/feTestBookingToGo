@extends('layouts.app')

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
                <input type="date" class="form-control" id="CstDob" name="CstDob" required>
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

            <h4>Keluarga <button type="button" id="addFamily" class="btn btn-link">+ Tambah Keluarga</button></h4>
            <div id="familyContainer">
                <div class="row mb-2 family-item">
                    <div class="col-md-5">
                        <input type="text" name="Family[0][FlName]" class="form-control" placeholder="Masukan Nama" required>
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="Family[0][FlDob]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger removeFamily">Hapus</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Kirim</button>
        </form>
    </div>
</main>
@endsection
@section('javascript')
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
            <div class="col-md-5">
                <input type="date" name="Family[${familyIndex}][FlDob]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeFamily">Hapus</button>
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
</script>
@endsection
