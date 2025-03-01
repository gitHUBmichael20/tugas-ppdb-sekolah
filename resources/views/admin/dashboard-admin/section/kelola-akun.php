<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h2 style="font-style: italic;">Opsi Tabel</h2>
    <select name="view" id="view">
        <option disabled selected>Pilih Tabel Yang Ingin Dilihat</option>
        <option value="table-siswa">Tabel Siswa</option>
        <option value="table-sekolah">Tabel Sekolah</option>
    </select>

    <div style="margin-top: 25px;" class="container murid-table">
        <h1 style="font-style: italic; color: #FB4141;">Tabel Siswa</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID Siswa</th>
                        <th>NISN</th>
                        <th>Nama Murid</th>
                        <th>Alamat</th>
                        <th>Tanggal lahir</th>
                        <th>Rapor Siswa</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Smith</td>
                        <td>Project Manager</td>
                        <td>Development</td>
                        <td>New York</td>
                        <td>2008</td>
                        <td>Active</td>
                        <td><button class="green-button">Edit</button>
                        <button class="red-button">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 25px" class="container sekolah-table">
        <h1 style="font-style:italic; color: #FB4141;">Tabel Sekolah</h1>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID Sekolah</th>
                        <th>Nama Sekolah</th>
                        <th>Jenis</th>
                        <th>Email</th>
                        <th>Kouta</th>
                        <th>Lokasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Smith</td>
                        <td>Project Manager</td>
                        <td>Development</td>
                        <td>New York</td>
                        <td>Active</td>
                        <td>Active</td>
                        <td><button class="green-button">Edit</button>
                        <button class="red-button">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Get the select element and table containers
        const viewSelect = document.getElementById('view');
        const muridTable = document.querySelector('.murid-table');
        const sekolahTable = document.querySelector('.sekolah-table');

        // Initially hide both tables
        muridTable.style.display = 'none';
        sekolahTable.style.display = 'none';

        // Add event listener for when the select option changes
        viewSelect.addEventListener('change', function() {
            // Get the selected value
            const selectedValue = this.value;

            // Show/hide tables based on selection
            if (selectedValue === 'table-siswa') {
                muridTable.style.display = 'block';
                sekolahTable.style.display = 'none';
            } else if (selectedValue === 'table-sekolah') {
                muridTable.style.display = 'none';
                sekolahTable.style.display = 'block';
            } else {
                muridTable.style.display = 'none';
                sekolahTable.style.display = 'none';
            }
        });
    </script>
</body>

</html>