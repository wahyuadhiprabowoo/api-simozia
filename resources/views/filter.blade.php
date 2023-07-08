<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Filter data</title>
</head>
<body>
<select name="puskesmas_id" id="puskesmasDropdown">
    <option value="">Pilih Puskesmas</option>
    @foreach($puskesmasList as $puskesmas)
        <option value="{{ $puskesmas->id }}">
            {{ $puskesmas->nama_puskesmas }}
        </option>
    @endforeach
</select>

<select name="posyandu_id" id="posyanduDropdown">
    <option value="">Pilih Posyandu</option>
</select>
<table>
    <thead>
        <tr>
            <th>Nama Ibu</th>
            <th>Nama Anak</th>
            <!-- Kolom-kolom lainnya -->
        </tr>
    </thead>
    <tbody id="balitaTableBody">
        <!-- Data balita akan ditampilkan di sini -->
    </tbody>
</table>
<br/>
<br/>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{url('filter.js')}}"></script>
{{-- balida --}}
<script>
$(document).ready(function() {
    // Fungsi untuk memperbarui dropdown Posyandu berdasarkan Puskesmas yang dipilih
    $('#puskesmasDropdown').change(function() {
        var selectedPuskesmasId = $(this).val();

        // Hapus data Posyandu yang ada
        $('#posyanduDropdown').empty().append('<option value="">Pilih Posyandu</option>');

        // Jika Puskesmas terpilih, ambil data Posyandu dari server
        if (selectedPuskesmasId) {
            $.ajax({
                url: '{{ route("posyandu.getPosyanduByPuskesmas") }}',
                type: 'GET',
                data: { puskesmas_id: selectedPuskesmasId },
                success: function(response) {
                    // Tambahkan data Posyandu ke dropdown
                    $.each(response, function(index, posyandu) {
                        $('#posyanduDropdown').append('<option value="' + posyandu.id + '">' + posyandu.nama_posyandu + '</option>');
                    });
                }
            });
        }
    });

    // Fungsi untuk memperbarui tabel Balita berdasarkan Puskesmas dan Posyandu yang dipilih
    $('#posyanduDropdown').change(function() {
        var selectedPuskesmasId = $('#puskesmasDropdown').val();
        var selectedPosyanduId = $(this).val();

        // Hapus data Balita yang ada
        $('#balitaTableBody').empty();

        // Jika Puskesmas dan Posyandu terpilih, ambil data Balita dari server
        if (selectedPuskesmasId && selectedPosyanduId) {
            $.ajax({
                url: '{{ route("balita.getBalitaByPosyandu") }}',
                type: 'GET',
                data: { puskesmas_id: selectedPuskesmasId, posyandu_id: selectedPosyanduId },
                success: function(response) {
                    // Tambahkan data Balita ke tabel
                    $.each(response, function(index, balita) {
                        var newRow = '<tr>' +
                            '<td>' + balita.nama_ibu + '</td>' +
                            '<td>' + balita.nama_anak + '</td>' +
                            '</tr>';
                        $('#balitaTableBody').append(newRow);
                    });
                }
            });
        }
    });
});
</script>


</body>
</html>