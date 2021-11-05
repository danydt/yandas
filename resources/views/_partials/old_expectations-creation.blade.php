<table class="table table-sm table-bordered" style="font-size: 12px">
    <thead>
    <tr>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 6%">MOIS DE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 7%">CATEGORIE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 10%">LIBELLE</td>
        <td rowspan="1" colspan="7" class="align-middle text-center" style="width: 49%">ACHATS A L'IMPORT</td>
        <td rowspan="1" colspan="3" class="align-middle text-center" style="width: 21%">ACHATS A L'EXPORT</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 7%">TOTAL GENERAL</td>
    </tr>
    <tr>
        <td rowspan="2" colspan="1" class="align-middle text-center">CIF</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">FRAIS BANC. 4% DU CIF</td>
        <td rowspan="1" colspan="2" class="align-middle text-center">FRAIS LOCAUX HORS TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">Divers</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TOTAL IMPORT</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">MONTANT HORS TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TOTAL LOCAL</td>
    </tr>
    <tr>
        <td class="align-middle text-center">% DU CIF</td>
        <td class="align-middle text-center">MONTANT</td>
    </tr>
    </thead>
    <tbody>

    @forelse($items as $key => $item)
        <tr>
            <td>{{ \Carbon\Carbon::parse($item->period)->locale('fr_FR')->isoFormat('LL') }}</td>
            <td>{{ sprintf('%s %s', $item->quantity, $item->label) }}</td>
            <td></td>
            <td>{{ $item->cif_value }}</td>
            <td>{{ $item->bank_fee_cif_value }}</td>
            <td>{{ $item->percentage_cif_value }}</td>
            <td>{{ $item->amount_percentage_cif_value }}</td>
            <td>{{ $item->divers_value }}</td>
            <td>{{ $item->vat_import_value }}</td>
            <td>{{ round($item->cif_value + $item->bank_fee_cif_value + $item->amount_percentage_cif_value + $item->divers_value + $item->vat_import_value)  }}</td>
            <td>{{ $item->local_amount_value }}</td>
            <td>{{ $item->local_vat_value }}</td>
            <td>{{ round($item->local_amount_value + $item->local_vat_value)  }}</td>
            <td>{{ round($item->cif_value + $item->bank_fee_cif_value + $item->amount_percentage_cif_value + $item->divers_value + $item->vat_import_value + $item->local_amount_value + $item->local_vat_value)  }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="14">
                <em>Aucun item !</em>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<script>
    function checkEnterPress(element, event) {

        if(parseInt(event.keyCode) === 13) {

            $(element).closest('tr').clone().insertAfter("tr:last");
        }
    }
</script>
