@extends('admin.layouts.app')

@section('page-title', 'Daftar Satuan Unit')

@section('content-admin')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Satuan Unit</h3>
        <a href="{{ route('admin.units.create') }}" class="btn btn-primary">Tambah Satuan Baru</a>
    </div>

    <table class="table w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Simbol</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $unit->id }}</td>
                    <td class="border px-4 py-2">{{ $unit->name }}</td>
                    <td class="border px-4 py-2">{{ $unit->symbol }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $units->links() }}
    </div>
@endsection