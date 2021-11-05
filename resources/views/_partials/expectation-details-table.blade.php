<table class="table table-sm table-bordered" style="font-size: 12px">
    <thead>
    <tr>
        <th rowspan="3" colspan="1" class="align-middle text-center" style="width: 6%">MOIS DE</th>
        <th rowspan="3" colspan="1" class="align-middle text-center" style="width: 5%">CATEGORIE</th>
        <th rowspan="3" colspan="1" class="align-middle text-center" style="width: 20%">LIBELLE</th>
        <th rowspan="1" colspan="7" class="align-middle text-center" style="width: 40%">ACHATS A L'IMPORT</th>
        <th rowspan="1" colspan="3" class="align-middle text-center" style="width: 19%">ACHATS LOCAUX</th>
        <th rowspan="3" colspan="1" class="align-middle text-center" style="width: 10%">TOTAL GENERAL</th>
    </tr>
    <tr>
        <th rowspan="2" colspan="1" class="align-middle text-center">CIF</th>
        <th rowspan="2" colspan="1" class="align-middle text-center" style="width: 5%">FRAIS BANC. % DU CIF</th>
        <th rowspan="1" colspan="2" class="align-middle text-center">FRAIS LOCAUX HORS TVA</th>
        <th rowspan="2" colspan="1" class="align-middle text-center">Divers</th>
        <th rowspan="2" colspan="1" class="align-middle text-center">TVA</th>
        <th rowspan="2" colspan="1" class="align-middle text-center">TOTAL IMPORT</th>
        <th rowspan="2" colspan="1" class="align-middle text-center">MONTANT HORS TVA</th>
        <th rowspan="2" colspan="1" class="align-middle text-center" style="width: 5%">TVA</th>
        <th rowspan="2" colspan="1" class="align-middle text-center">TOTAL LOCAL</th>
    </tr>
    <tr>
        <th class="align-middle text-center">% DU CIF</th>
        <th class="align-middle text-center">MONTANT</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_cif = [];
        $total_bank_fee = [];
        $total_cif_amount = [];
        $total_divers = [];
        $total_import_vat = [];
        $total_import = [];
        $total_export_amount = [];
        $total_export_vat = [];
        $total_export = [];
        $total_general = [];

        $total_all_import = [];
        $total_all_export = [];
        $total_all_general = [];
    @endphp
    @forelse($expectation->details as $index => $item)
        <tr>
            <td>{{ substr($item->month->name, 0, 4) . '-' . $year }}</td>
            <td>{{ substr($item->budgetForecastCategory->name, 0, 4) }}</td>
            <td>
                @if($item->quantity > 0) {{ $item->quantity }} @endif <u>{{ $item->label }}</u>
                @if($item->quantity > 0 and substr($item->label[0], -1, 1) != 's')

                @endif
                @if($item->observation ) <br><em>{{ $item->observation }}</em><br> @endif
                @if($item->investment_name ) <br><strong><em>INV: {{ $item->investment_name }}</em></strong> @endif
            </td>
            <td class="text-right">
                {{ number_format($item->cif_value, 0, ',', ' ') }}
                @php
                    array_push($total_cif, $item->cif_value);
                @endphp
            </td>
            <td class="text-right">
                {{ number_format($item->bank_fee_cif_value, 0, ',', ' ') }}
                ({{ $item->default_cif_percent }}%)
                @php
                    array_push($total_bank_fee, $item->bank_fee_cif_value);
                @endphp
            </td>
            <td class="text-right">{{ $item->percentage_cif_value }}</td>
            <td class="text-right">
                {{ number_format($item->amount_percentage_cif_value, 0, ',', ' ') }}
                @php
                    array_push($total_cif_amount, $item->amount_percentage_cif_value);
                @endphp
            </td>
            <td class="text-right">
                {{ number_format($item->divers_value, 0, ',', ' ') }}
                ({{ $item->default_divers_percent }}%)
                @php
                    array_push($total_divers, $item->divers_value);
                @endphp
            </td>
            <td class="text-right">
                {{ number_format($item->vat_import_value, 0, ',', ' ') }}
                ({{ $item->default_import_vat_percent }}%)
                @php
                    array_push($total_import_vat, $item->vat_import_value);
                @endphp
            </td>
            <td class="text-right">
                @php
                    $total_import = $total_import_vat[$index] +  $total_divers[$index] +  $total_cif_amount[$index] +  $total_bank_fee[$index] +  $total_cif[$index]
                @endphp

                {{ number_format($total_import, 0, ',', ' ') }}

                @php
                    array_push($total_all_import, $total_import);
                @endphp
            </td>
            <td class="text-right">
                {{ number_format($item->local_amount_value, 0, ',', ' ') }}
                @php
                    //$total_export_amount = $total_export_amount + $item->local_amount_value;
                    array_push($total_export_amount, $item->local_amount_value)
                @endphp
            </td>
            <td class="text-right">
                {{ number_format($item->local_vat_value, 0, ',', ' ') }}
                ({{ $item->default_export_vat_percent }}%)
                @php
                    //$total_export_vat = $total_export_vat + $item->local_vat_value;
                    array_push($total_export_vat, $item->local_vat_value)

                @endphp
            </td>
            <td class="text-right">
                @php
                    $total_export = $total_export_vat[$index] +  $total_export_amount[$index]
                @endphp

                {{ number_format($total_export, 0, ',', ' ') }}

                @php
                    array_push($total_all_export, $total_export);
                @endphp
            </td>
            <td class="text-right">
                @php
                    $total_general = $total_all_export[$index] +  $total_all_import[$index]
                @endphp

                {{ number_format($total_general, 0, ',', ' ') }}

                @php
                    array_push($total_all_general, $total_general);
                @endphp
            </td>
        </tr>
    @empty
    @endforelse
    <tr>
        <td colspan="3" class="align-middle text-center"><strong>TOTAL DE LA RUBRIQUE</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_cif), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_bank_fee), 0, ',', ' ') }}</strong></td>
        <td class="text-right"></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_cif_amount), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_divers), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_import_vat), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_import), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_export_amount), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_export_vat), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_export), 0, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_general), 0, ',', ' ') }}</strong></td>
    </tr>
    </tbody>
</table>
