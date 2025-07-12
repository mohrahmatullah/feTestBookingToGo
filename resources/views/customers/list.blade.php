@extends('layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-5">Customer</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <a type="button" href="{{ route('customers.create') }}" class="btn btn-dark btn-sm"><i class="fa fa-plus"></i> Tambah Customer</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Customer</th>
                            <th>Tanggal Lahir</th>
                            <th>Kewarganegaraan</th>
                            <th>Family Members</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer['CstName'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($customer['CstDob'])->format('d-m-Y') }}</td>
                            <td>{{ $customer['Nationality']['NationalityName'] }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach($customer['FamilyList'] as $family)
                                        <li>{{ $family['FlName'] }} ({{ $family['FlDob'] }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="{{ route('customers.edit', $customer['CstID']) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                                <form action="{{ route('customers.destroy', $customer['CstID']) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    <a href="{{ url()->current() }}?page={{ request('page', 1) - 1 }}" class="btn btn-sm btn-secondary {{ request('page', 1) <= 1 ? 'disabled' : '' }}">Sebelumnya</a>
                    <a href="{{ url()->current() }}?page={{ request('page', 1) + 1 }}" class="btn btn-sm btn-secondary">Berikutnya</a>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection

@section('javascript')
@endsection
