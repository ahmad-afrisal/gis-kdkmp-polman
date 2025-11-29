<!DOCTYPE html>
<html>
<meta charset="UTF-8">

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;

        }

        table {
            font-size: 5px;
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* PENTING: supaya kolom tidak melebar */
            word-wrap: break-word;
            /* Agar isi panjang dibungkus */
        }

        th {
            background-color: #20b625;

        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        /* Atur lebar kolom yang terlalu lebar */
        .col-nama {
            width: 180px;
        }

        .col-sk {
            width: 150px;
        }

        .col-potensi {
            width: 120px;
        }
    </style>

</head>

<body>


    {{-- Form 1 --}}
    <p><b>FORM 1. Asistensi Kelengkapan Informasi di dalam sistem Informasi Desa/Kelurahan
            Merah Putih (SIMKOPDES) </b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>


    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama KDKMP</th>
                <th colspan="2">Pendaftaran Akun</th>
                <th colspan="3">Profil Koperasi</th>
                <th colspan="6">Gerai</th>
                <th colspan="2">Akun Bank</th>
                <th colspan="2">Potensi</th>


            </tr>
            <tr>
                <th>Sudah Terdaftar</th>
                <th>Belum Terdaftar</th>

                <th>Berita Acara Musdesus/Msukalsus</th>
                <th>Bertiat Acara rapat Anggota</th>
                <th>SK AHU Koperasi</th>

                <th>Sembako</th>
                <th>Apotek</th>
                <th>Klinik</th>
                <th>Unit Simpan Pinjam</th>
                <th>Pergudangan / Cold Storage</th>
                <th>Logistik</th>

                <th>Akun Bank</th>
                <th>Belum Tersedia Akun</th>

                <th>Terisi</th>
                <th>Belum Terisi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cooperations as $index => $coop)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $coop->name }}</td>

                    <td>{{ $coop->microsite_account ? '✔' : '' }}</td>
                    <td>{{ !$coop->microsite_account ? '✔' : '' }}</td>

                    <td>{{ $coop->ba_musdes ? 'Ada' : 'Belum Ada' }}</td>
                    <td>{{ $coop->ba_rapat_anggota ? 'Ada' : 'Belum Ada' }}</td>
                    <td>{{ $coop->legal_entity_number }}</td>

                    <td>{{ $coop->grocery_outlet ? '✔' : '' }}</td>
                    <td>{{ $coop->village_pharmacy_outlet ? '✔' : '' }}</td>
                    <td>{{ $coop->village_clinic_outlet ? '✔' : '' }}</td>
                    <td>{{ $coop->savings_and_loan_outlet ? '✔' : '' }}</td>
                    <td>{{ $coop->cold_storage_outlet ? '✔' : '' }}</td>
                    <td>{{ $coop->logistics_outlet ? '✔' : '' }}</td>

                    <td>{{ $coop->bank_account ? '✔' : '' }}</td>
                    <td>{{ !$coop->bank_account ? '✔' : '' }}</td>

                    <td>{{ $coop->potential ?? '' }}</td>
                    <td>{{ empty($coop->potential) ? '✔' : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always;"></div>
    {{-- Form 2 --}}
    <p><b>FORM 2. Asistensi Rencana Bisnis dan implementasinya untuk memulai operasional KDKMP </b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>
    <table ">

        <thead>
            <tr class="bg-green-600 ">
                <th rowspan="3" class="">No</th>
                <th rowspan="3" class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                    Nama KDKMP
                </th>
                <th rowspan="3" class="w-[500px] min-w-[300px] border border-gray-300 px-2 py-1">
                    Rencana Bisnis
                </th>
                <th colspan="14">Rencana Bisnis Gerai</th>
                <th rowspan="3" class="w-[500px] min-w-[300px] border border-gray-300 px-2 py-1">
                    Keterangan
                </th>

            </tr>
            <tr class="bg-green-600 ">
                <th colspan="2" class="">Pengadaan Sembako</th>
                <th colspan="2" class="">Usaha Simpan Pinjam</th>
                <th colspan="2" class="">Apotek Desa</th>
                <th colspan="2" class="">Klinik Desa</th>
                <th colspan="2" class="">Logistik</th>
                <th colspan="2" class="">Cold Storage/
                    Pergudangan</th>
                <th colspan="2" class="">Kegiatan Usaha Lain</th>
            </tr>
            <tr class="bg-green-700 ">
                {{-- Pengadaan Sembako --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Simpan Pinjam --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Apotek Desa --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Klinik Desa --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Logistik --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Cold Storage/Pergudangan --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>

                {{-- Kegiatan Usaha Lain --}}
                <th class="">Ada/Tidak</th>
                <th class="">Berjalan/Belum</th>
            </tr>
        </thead>

        <tbody class="text-gray-700">
                @forelse ($cooperations as $index=> $coop)
        @php
            $form = $coop->formTwo; // Bisa null, aman
        @endphp
        <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
            <td style="text-align: center">
                {{ $index + 1 }}
            </td>

            {{-- Hidden cooperation_id --}}
            <input type="hidden" name="data[{{ $index }}][cooperation_id]" value="{{ $coop->id }}">

            {{-- Nama Koperasi --}}
            <td>
                {{ $coop->name ?? '' }}
            </td>
            <td class="border border-gray-300 px-2 py-1">
                {{ $form?->bussiness_plan ?? '' }}
            </td>


            {{-- Pengadaan Sembako --}}
            <td style="text-align: center">
                {{ $form?->basic_necessities_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->basic_necessities_running ? '✔' : '' }}
            </td>

            {{-- Usaha Simpan Pinjam --}}
            <td style="text-align: center">
                {{ $form?->savings_and_loan_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->savings_and_loan_running ? '✔' : '' }}
            </td>

            {{-- Apotek Desa --}}
            <td style="text-align: center">
                {{ $form?->pharmacy_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->pharmacy_running ? '✔' : '' }}
            </td>

            <td style="text-align: center">
                {{ $form?->clinic_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->clinic_running ? '✔' : '' }}
            </td>

            <td style="text-align: center">
                {{ $form?->logistics_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->logistics_running ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->storage_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->storage_running ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->other_businesses_exist ? '✔' : '' }}
            </td>
            <td style="text-align: center">
                {{ $form?->other_businesses_running ? '✔' : '' }}
            </td>
            <td class="border border-gray-300 px-2 py-1">
                {{ $form?->information ?? '' }}
            </td>


        </tr>
    @empty
        <tr>
            <td colspan="17" class="border border-gray-300 px-4 py-3 text-center text-gray-500 italic">
                Tidak ada data koperasi untuk BA ini.
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>

</body>

</html>
