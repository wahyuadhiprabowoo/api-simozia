<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Data Posyandu</title>
</head>
<body>
  {{-- show posyandu --}}
<select name="puskesmas_id" id="puskesmasDropdown">
    <option value="">Pilih Puskesmas</option>
    @foreach($puskesmasList as $puskesmas)
        <option value="{{ $puskesmas->id }}">{{ $puskesmas->nama_puskesmas }}</option>
    @endforeach
</select>


<form action="" method="">
@csrf
<table>
    <thead>
        <tr>
            <th>Nama Posyandu</th>
            <th>Alamat</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Aksi</th> 
            <!-- Kolom-kolom lainnya -->
        </tr>
    </thead>
    <tbody id="posyanduTableBody">
        <!-- Data posyandu akan ditampilkan di sini -->
    </tbody>
</table>
</form>
<br>
<br>

{{-- post balita --}}
<form method="POST" action="{{ route('posyandu.store') }}">
    @csrf

    <label for="puskesmas_id">Puskesmas</label>
    <select name="puskesmas_id" id="puskesmas_id">
        <option value="">Pilih Puskesmas</option>
        @foreach($puskesmasList as $puskesmasItem)
            <option value="{{ $puskesmasItem->id }}">{{ $puskesmasItem->nama_puskesmas }}</option>
        @endforeach
    </select>

    <label for="nama_posyandu">Nama Posyandu</label>
    <input type="text" name="nama_posyandu" id="nama_posyandu">

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat">

    <label for="kelurahan">Kelurahan</label>
    <input type="text" name="kelurahan" id="kelurahan">

    <label for="kecamatan">Kecamatan</label>
    <input type="text" name="kecamatan" id="kecamatan">

    <button type="submit">Simpan</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#puskesmasDropdown').change(function() {
        var selectedPuskesmasId = $(this).val();

        $.ajax({
            url: '{{ route("posyandu.getPosyanduByPuskesmasOnly") }}',
            type: 'GET',
            data: { puskesmas_id: selectedPuskesmasId },
            success: function(response) {
                var posyanduTableBody = $('#posyanduTableBody');
                posyanduTableBody.empty();
                $.each(response, function(index, posyandu) {
    var row = '<tr id="posyanduRow_' + posyandu.id + '">' +
        '<td>' + posyandu.nama_posyandu + '</td>' +
        '<td>' + posyandu.alamat + '</td>' +
        '<td>' +
        '<button class="btn-delete-posyandu" data-puskesmas-id="' + selectedPuskesmasId + '" data-posyandu-id="' + posyandu.id + '">Delete</button>' +
        '</td>' +

        '</tr>';
    $('#posyanduTableBody').append(row);
});

                
            }
        });
    });
});

$(document).ready(function() {
    $('#puskesmasDropdown').change(function() {
        var selectedPuskesmasId = $(this).val();

        $.ajax({
            url: '{{ route("posyandu.getPosyanduByPuskesmasOnly") }}',
            type: 'GET',
            data: { puskesmas_id: selectedPuskesmasId },
            success: function(response) {
                var posyanduTableBody = $('#posyanduTableBody');
                posyanduTableBody.empty();
                $.each(response, function(index, posyandu) {
    var row = '<tr id="posyanduRow_' + posyandu.id + '">' +
        '<td>' + posyandu.nama_posyandu + '</td>' +
        '<td>' + posyandu.alamat + '</td>' +
        '<td>' +
        '<button class="btn-delete-posyandu" data-puskesmas-id="' + selectedPuskesmasId + '" data-posyandu-id="' + posyandu.id + '">Delete</button>' +
        '</td>' +

        '</tr>';
    $('#posyanduTableBody').append(row);
});

                
            }
        });
    });
});
// delete posyandu
function deletePosyandu(puskesmasId, posyanduId) {
    $.ajax({
        url: '{{ route("posyandu.delete") }}',
        type: 'DELETE',
        data: {
            puskesmas_id: puskesmasId,
            posyandu_id: posyanduId,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Hapus baris tabel yang terkait dengan posyandu yang dihapus
            $('#posyanduRow_' + posyanduId).remove();
        }
    });
}
// onclick button
$(document).on('click', '.btn-delete-posyandu', function() {
    var puskesmasId = $(this).data('puskesmas-id');
    var posyanduId = $(this).data('posyandu-id');
    deletePosyandu(puskesmasId, posyanduId);
});

// {{-- edit posyandu --}}
</script>

</body>
</html>