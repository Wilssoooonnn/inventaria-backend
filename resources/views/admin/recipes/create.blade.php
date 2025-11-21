@extends('admin.layouts.app')

@section('page-title', 'Buat Resep Baru')

@section('content-admin')
    <h3>Formulir Resep</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.recipes.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="menu_id">Menu Produk Jadi:</label>
            <select name="menu_id" class="form-control" required>
                <option value="">Pilih Menu...</option>
                @foreach ($menu_items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} (Rp{{ number_format($item->sale_price, 0) }})</option>
                @endforeach
            </select>
        </div>

        <hr>

        <h4>Daftar Bahan Baku Digunakan:</h4>
        <div id="ingredients-container">
        </div>

        <button type="button" id="add-ingredient" class="btn btn-secondary btn-sm mt-2">
            + Tambah Bahan
        </button>

        <hr>
        <button type="submit" class="btn btn-primary mt-3">Simpan Resep</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('ingredients-container');
            const addButton = document.getElementById('add-ingredient');
            let ingredientIndex = 0;

            function addIngredientRow() {
                const newRow = document.createElement('div');
                newRow.classList.add('input-group', 'mb-3');

                newRow.innerHTML = `
                        <select name="ingredients[${ingredientIndex}][ingredient_id]" required class="form-select w-50">
                            <option value="">Pilih Bahan...</option>
                            {{-- Data ingredients dibuat dalam loop di Controller --}}
                            @foreach ($ingredients as $ing)
                                <option value="{{ $ing->id }}">{{ $ing->name }} (Satuan: {{ $ing->unit->symbol ?? 'pcs' }})</option>
                            @endforeach
                        </select>
                        <input type="number" step="0.0001" name="ingredients[${ingredientIndex}][quantity_used]" 
                               placeholder="Kuantitas Terpakai (cth: 0.150)" required class="form-control w-25">
                        <button type="button" class="btn btn-danger remove-row">Hapus</button>
                    `;
                container.appendChild(newRow);
                ingredientIndex++;
            }

            addButton.addEventListener('click', addIngredientRow);

            container.addEventListener('click', function (e) {
                if (e.target && e.target.matches('button.remove-row')) {
                    e.target.closest('.input-group').remove();
                }
            });

            addIngredientRow();
        });
    </script>
@endsection