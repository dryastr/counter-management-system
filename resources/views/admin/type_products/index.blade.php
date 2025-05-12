@extends('layouts.main')

@section('title', 'Tipe Produk')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Tipe Produk</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTypeProductModal">
                            Tambah Tipe Produk Baru
                        </button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tipe Produk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($typeProducts as $typeProduct)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $typeProduct->name }}</td>
                                            <td class="text-nowrap">
                                                <div class="dropdown dropup">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton-{{ $typeProduct->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $typeProduct->id }}">
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#editTypeProductModal"
                                                                onclick="editTypeProduct({{ json_encode($typeProduct) }})">Ubah</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('type-products.destroy', $typeProduct->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus Tipe Produk ini?')">
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

    <!-- Add Modal -->
    <div class="modal fade" id="addTypeProductModal" tabindex="-1" aria-labelledby="addTypeProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTypeProductModalLabel">Tambah Tipe Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('type-products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type_product_name" class="form-label">Nama Tipe Produk</label>
                            <input type="text" class="form-control" id="type_product_name" name="name" required>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editTypeProductModal" tabindex="-1" aria-labelledby="editTypeProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTypeProductModalLabel">Ubah Tipe Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTypeProductForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_type_product_name" class="form-label">Nama Tipe Produk</label>
                            <input type="text" class="form-control" id="edit_type_product_name" name="name" required>
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
@endsection

@push('scripts')
    <script>
        function editTypeProduct(typeProduct) {
            document.getElementById('editTypeProductForm').action = `/type-products/${typeProduct.id}`;
            document.getElementById('edit_type_product_name').value = typeProduct.name;
            $('#editTypeProductModal').modal('show');
        }
    </script>
@endpush
