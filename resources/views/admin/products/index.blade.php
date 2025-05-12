@extends('layouts.main')

@section('title', 'Daftar Produk')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Produk</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            Tambah Produk Baru
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Tipe Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Diskon</th>
                                        <th>Supplier</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->typeProduct->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->discount }}</td>
                                            <td>{{ $product->supplier }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $product->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $product->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#editProductModal"
                                                                onclick="editProduct({{ json_encode($product) }})">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">Hapus</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="type_product_id" class="form-label">Tipe Produk</label>
                            <select name="type_product_id" class="form-select" required>
                                @foreach ($typeProducts as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="discount" class="form-label">Diskon</label>
                            <input type="number" name="discount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier" class="form-label">Supplier</label>
                            <input type="text" name="supplier" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editProductForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function editProduct(product) {
            $('#editProductForm').attr('action', `/products/${product.id}`);
            $('#editProductForm .modal-body').html(`
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="${product.name}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipe Produk</label>
            <select name="type_product_id" class="form-select" required>
                @foreach ($typeProducts as $type)
                    <option value="{{ $type->id }}" ${product.type_product_id == {{ $type->id }} ? 'selected' : ''}>{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="${product.price}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="${product.stock}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Diskon</label>
            <input type="number" name="discount" class="form-control" value="${product.discount}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" value="${product.supplier}" required>
        </div>
    `);
        }
    </script>
@endpush
