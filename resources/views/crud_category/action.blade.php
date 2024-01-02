<div class="modal fade" id="deletecategory{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4 rounded-card">
            <!-- Menambahkan padding sebesar 4 -->
            <div class="modal-header">
                <h5 class="modal-title">DELETE KATEGORI</h5>
            </div>
            <div class="modal-body">
                <p class="pt-3 text-dark">Apakah Anda yakin</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <form action="{{ route('kategori.delete', $item->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-success">OK</button>
                </form>
            </div>
        </div>
    </div>
</div>