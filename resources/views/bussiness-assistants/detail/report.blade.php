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
    <table>

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
                    <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                        value="{{ $coop->id }}">

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

    {{-- Form 3 --}}

    <div style="page-break-after: always;"></div>
    <p><b>FORM 3. Kelengkapan administrasi perizinan berusaha</b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>

    <table class="min-w-full text-sm text-center border-collapse">

        <thead>
            <tr class="bg-green-600 ">
                <th rowspan="2" class="border border-gray-300 px-3 py-2">No</th>
                <th rowspan="2" class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                    Nama KDKMP
                </th>
                <th rowspan="2" class="border border-gray-300 px-3 py-2">Mitra Pembiayaan</th>
                <th colspan="10" class="border border-gray-300 px-3 py-2">Dokumen Kelengkapan
                    Proposal</th>
            </tr>
            <tr class="bg-green-700 ">
                <th>AKTA BH</th>
                <th>NIK Koperasi</th>
                <th>Rekening Bank Koperasi</th>
                <th>NPWP</th>
                <th>NIB</th>
                <th>Rencana Kegiatan Bisnis</th>
                <th>Belanja Modal (Capex)</th>
                <th>Belanja Operasional (Opex)</th>
                <th>kelengkapan Lain</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody class="text-gray-700">
            @forelse ($cooperations as $index => $coop)
                @php
                    $form = $coop->formThree; // Bisa null, aman
                @endphp
                <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                    <td style="text-align: center">
                        {{ $index + 1 }}
                    </td>

                    {{-- Nama Koperasi --}}
                    <td>
                        {{ $coop->name }}
                    </td>

                    <td style="text-align: center">
                        {{ $form?->financing_partner ?? '' }}
                    </td>

                    {{-- Hidden cooperation_id --}}
                    <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                        value="{{ $coop->id }}">


                    <td style="text-align: center">
                        {{ $form?->bh_deed ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->cooperative_nik ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->cooperative_bank_account ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->npwp ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->nib ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->business_activity_plan ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->capex ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->opex ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->other_equipment ? '✔' : '' }}
                    </td>
                    <td class="border
                        border-gray-300 px-2 py-1">
                        {{ $form?->information }}"
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

    {{-- Form 4 --}}

    <div style="page-break-after: always;"></div>
    <p><b>FORM 4. Membantu penyusunan proposal bisnis KDKMP</b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>

    <table class="min-w-full text-sm text-center border-collapse">

        <thead>
            <tr class="bg-green-600 ">
                <th rowspan="2" class="border border-gray-300 px-3 py-2">No</th>
                <th rowspan="2" class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                    Nama KDKMP
                </th>
                <th rowspan="2" class="border border-gray-300 px-3 py-2">Mitra Pembiayaan</th>
                <th colspan="2" class="border border-gray-300 px-3 py-2">Proposal Pembiayaan</th>
                <th rowspan="2" class="border border-gray-300 px-3 py-2">Tanggal Pengajuan
                    Proposal Pembiayaan</th>
                <th colspan="2" class="border border-gray-300 px-3 py-2">Status Proposal</th>
                <th rowspan="2" class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                    Jumlah Pembiayaan</th>
                <th rowspan="2" class="w-[600px] min-w-[300px] border border-gray-300 px-3 py-2">
                    Keterangan</th>

            </tr>
            <tr class="bg-green-700 ">
                <th class="border border-gray-300 px-3 py-2">Ada</th>
                <th class="border border-gray-300 px-3 py-2">Belum</th>

                <th class="border border-gray-300 px-3 py-2">Ditolak</th>
                <th class="border border-gray-300 px-3 py-2">Disetujui</th>

            </tr>
        </thead>

        <tbody class="text-gray-700">
            @forelse ($cooperations as $index => $coop)
                @php
                    $form = $coop->formFour; // Bisa null, aman
                @endphp
                <tr class="odd:bg-gray-50 even:bg-white hover:bg-green-50 transition">
                    <td style="text-align: center">
                        {{ $index + 1 }}
                    </td>

                    {{-- Hidden cooperation_id --}}
                    <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                        value="{{ $coop->id }}">

                    {{-- Nama Koperasi --}}
                    <td>
                        {{ $coop->name ?? '' }}
                    </td>

                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->financing_partner ?? '' }}
                    </td>

                    <td style="text-align: center">
                        {{ $form?->financing_proposal ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ !$form?->financing_proposal ? '✔' : '' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->financing_proposal_submission_date ?? '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->proposal_status === 0 ? '✔' : '' }}
                    </td>
                    <td style="text-align: center">
                        {{ $form?->proposal_status === 1 ? '✔' : '' }}
                    </td>

                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->financing_amount ?? '' }}
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

    <div style="page-break-after: always;"></div>
    <p><b>FORM 5. Pendataan Aset Tanah atau Bangunan</b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>

    <table class="min-w-full text-sm text-center border-collapse">
        <thead>
            <tr class="bg-green-600 text-white">
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Nama KDKMP</th>
                <th class="border px-3 py-2">Gerai</th>
                <th class="border px-3 py-2">Volume Usaha</th>
                <th class="border px-3 py-2">Total Aset</th>
                <th class="border px-3 py-2">Laba/Rugi</th>
                <th class="border px-3 py-2">Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cooperations as $index => $coop)
                @php
                    $rows = $coop->formFives;
                    $rowCount = $rows->count();
                @endphp

                {{-- Jika tidak ada gerai, tetap tampil 1 baris --}}
                @if ($rowCount === 0)
                    <tr>
                        <td class="border px-2 py-1">{{ $index + 1 }}</td>
                        <td class="border px-2 py-1">{{ $coop->name }}</td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1"></td>
                        <td class="border px-2 py-1"></td>
                    </tr>
                @else
                    @foreach ($rows as $rIndex => $formFive)
                        <tr>
                            {{-- Tampilkan rowspannya hanya pada baris pertama --}}
                            @if ($rIndex === 0)
                                <td class="border px-2 py-1" rowspan="{{ $rowCount }}">
                                    {{ $index + 1 }}
                                </td>

                                <td class="border px-2 py-1" rowspan="{{ $rowCount }}">
                                    {{ $coop->name }}
                                </td>
                            @endif

                            <td class="border px-2 py-1">
                                {{ $formFive?->branch_type }}
                            </td>

                            <td class="border px-2 py-1">
                                {{ $formFive?->business_volume }}
                            </td>

                            <td class="border px-2 py-1">
                                {{ $formFive?->total_assets }}
                            </td>

                            <td class="border px-2 py-1">
                                {{ $formFive?->profit_loss }}
                            </td>

                            <td class="border px-2 py-1">
                                {{ $formFive?->information }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>



    <div style="page-break-after: always;"></div>
    <p><b>FORM 6. Pendataan Aset Tanah atau Bangunan</b></p>
    <p>Nama &nbsp; : {{ $bussinessAssistant->name }}</p>
    <p style="margin: 0;">Kabupaten &nbsp; : Polewali Mandar</p>
    <p>Provinsi &nbsp; : Sulawesi Barat</p>
    <table class="min-w-full text-sm text-center border-collapse">

        <thead>
            <tr class="bg-green-600 ">
                <th class="border border-gray-300 px-3 py-2">No</th>
                <th class="w-[800px] min-w-[600px] border border-gray-300 px-2 py-1">
                    Nama KDKMP
                </th>
                <th class=" min-w-[300px] border border-gray-300 px-3 py-2">Foto Tanah</th>
                <th class="w-[400px] min-w-[300px] border border-gray-300 px-3 py-2">Titik Koordinat
                </th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Lebar Tanah</th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Panjang Tanah</th>
                <th class="min-w-[250px] border border-gray-300 px-3 py-2">Surat Tanah</th>
                <th class="min-w-[220px] border border-gray-300 px-3 py-2">Kondisi Jalan</th>
                <th class="min-w-[220px] border border-gray-300 px-3 py-2">Tipe Aset</th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Jarak Permukiman</th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Internet</th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Air</th>
                <th class="min-w-[120px] border border-gray-300 px-3 py-2">Akses Listrik</th>
            </tr>

        </thead>

        <tbody class="text-gray-700">
            @forelse ($cooperations as $index => $coop)
                @php
                    $form = $coop->formSix; // Bisa null, aman
                @endphp
                <tr style="text-align: center">
                    <td class="border border-gray-300 px-2 py-1 font-medium text-center">
                        {{ $index + 1 }}
                    </td>

                    {{-- Nama Koperasi --}}
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $coop->name ?? '' }}
                    </td>


                    <td class="border border-gray-300 px-2 py-1">
                        <div class="flex items-center gap-3">
                            <!-- Preview gambar -->
                            @if (!empty($form?->picture_land))
                                <img src="{{ public_path('storage/' . $form->picture_land) }}" width="75">
                            @endif


                        </div>



                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        <div class="flex gap-2">
                            {{ $form?->latitude ?? '' }}, {{ $form?->longitude ?? '' }}
                        </div>
                    </td>


                    {{-- Profil Koperasi --}}
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->width_land ?? '' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->long_land ?? '' }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">

                        @if (!empty($form?->letter_land))
                            <img src="{{ public_path('storage/' . $form->letter_land) }}" width="75">
                        @endif

                    </td>

                    {{-- Gerai --}}
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        {{ $form?->road_condition }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        {{ $form?->asset }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ $form?->distance ?? '' }}

                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        {{ $form?->internet_access ?? '' }}

                    </td>
                    <td class="border border-gray-300 px-2 py-1 text-center">
                        {{ $form?->water_access }}
                    </td>
                    {{-- Hidden cooperation_id --}}
                    <input type="hidden" name="data[{{ $index }}][cooperation_id]"
                        value="{{ $coop->id }}">

                    <td class="border border-gray-300 px-2 py-1 text-center">
                        {{ $form?->electricity_access }}
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
