<table class="table table-sm table-bordered" style="font-size: 10px; width: 100%">
    <thead>
    <tr>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 4%">MOIS DE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 7%">CATEGORIE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 10%">LIBELLE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 3%">DESCRIPTION</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 4%">QUANTITE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 6%">UNITE</td>
        <td rowspan="1" colspan="7" class="align-middle text-center" style="width: 40%">ACHATS A L'IMPORT</td>
        <td rowspan="1" colspan="3" class="align-middle text-center" style="width: 19%">ACHATS LOCAUX</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 20%">TOTAL GENERAL</td>
    </tr>
    <tr>
        <td rowspan="2" colspan="1" class="align-middle text-center">CIF</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">
            FRAIS BANC. % DU CIF <br>
            <input aria-label="default cif" type="number" id="default_cif" value="4" min="0" max="4" onbeforeinput="changeDefaultPercents(this.value, 'line_default_cif_percent[]', 1)" onchange="changeDefaultPercents(this.value, 'line_default_cif_percent[]', 1)">
        </td>
        <td rowspan="1" colspan="2" class="align-middle text-center">FRAIS LOCAUX HORS TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">
            Divers <br>
            <input aria-label="divers" type="number" id="default_divers" value="12" min="0" max="12" onbeforeinput="changeDefaultPercents(this.value, 'line_default_divers_percent[]', 1)" onchange="changeDefaultPercents(this.value, 'line_default_divers_percent[]', 1)">
        </td>
        <td rowspan="2" colspan="1" class="align-middle text-center">
            TVA <br>
            <input aria-label="import vat" type="number" id="default_import_vat" value="16" min="0" max="16" onbeforeinput="changeDefaultPercents(this.value, 'line_default_import_vat_percent[]', 1)" onchange="changeDefaultPercents(this.value, 'line_default_import_vat_percent[]', 1)">
        </td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TOTAL IMPORT</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">MONTANT HORS TVA</td>
        <td rowspan="2" colspan="1" class="align-middle text-center">
            TVA <br>
            <input aria-label="export vat" type="number" id="default_export_vat" value="16" min="0" max="16" onbeforeinput="changeDefaultPercents(this.value, 'line_default_export_vat_percent[]', 2)" onchange="changeDefaultPercents(this.value, 'line_default_export_vat_percent[]', 2)">
        </td>
        <td rowspan="2" colspan="1" class="align-middle text-center">TOTAL LOCAL</td>
    </tr>
    <tr>
        <td class="align-middle text-center">% DU CIF</td>
        <td class="align-middle text-center">MONTANT</td>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="17" class="align-content-end"><a href="{{ route('expectations.index') }}" class="btn btn-sm btn-success">Fermer</a></td>
    </tr>
    </tfoot>
    <tbody>

    @foreach($expectation->details as $content)

    <tr>
        <td>
            <select aria-label="period" name="_period[]" class="form-control form-control-sm">
                <option value="">...</option>
                @foreach($months as $item => $value) {
                <option @if($content->month_code == $value) selected @endif value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </td>
        <td>

            <input type="hidden" name="line_default_cif_percent[]" value="{{ $content->default_cif_percent }}">
            <input type="hidden" name="line_default_divers_percent[]" value="{{ $content->default_divers_percent }}">
            <input type="hidden" name="line_default_import_vat_percent[]" value="{{ $content->default_import_vat_percent }}">
            <input type="hidden" name="line_default_export_vat_percent[]" value="{{ $content->default_export_vat_percent }}">

            <select aria-label="category" name="category[]" class="form-control form-control-sm">
                <option value="">Sélectionner..</option>
                @foreach($categories as $item)
                <option @if($item->code == $content->category_code) selected @endif value="{{ $item->code }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select aria-label="label" name="label[]" class="form-control form-control-sm">
                <option value="{{ $content->label }}">{{ $content->label }}</option>
            </select>
        </td>
        <td class="align-middle text-center">
            <a class="link-dark" style="cursor: pointer" onmouseover="showInfoBull(this)" onclick="return setDescription(this)"  data-toggle="modal" data-target="#staticBackdrop">
                Ajouter
            </a>
            <input type="hidden" name="description[]" aria-label="description" value="{{ $content->observation }}">
        </td>
        <td><input type="number" min="1" name="quantity[]" aria-label="quantity" class="form-control form-control-sm" placeholder="Quantité" value="{{ $content->quantity }}"></td>
        <td>
            <select aria-label="unit" name="unit[]" class="form-control form-control-sm">
                <option value="">Sélectionner..</option>
                @foreach($units as $item)
                <option @if($item->code == $content->unit_of_measure_code) selected @endif value="{{ $item->code }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" min="1" onkeyup="calculateBankAndDiverseFees(this)" name="cif_value[]" aria-label="cif" class="form-control form-control-sm" placeholder="CIF" value="{{ $content->cif_value }}" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" readonly name="bank_fees[]" aria-label="bank_fees" class="form-control form-control-sm" placeholder="Frais bancaire" value="{{ $content->bank_fee_cif_value }}"></td>
        <td><input type="number" min="1" onchange="calculateCifAmountBankFees(this)" onkeyup="calculateCifAmountBankFees(this)" name="cif_percent[]" aria-label="cif_percent" class="form-control form-control-sm" placeholder="% CIF" value="{{ $content->percentage_cif_value }}" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" name="cif_amount[]" readonly aria-label="amount" class="form-control form-control-sm" placeholder="Montant" value="{{ $content->amount_percentage_cif_value }}"></td>
        <td><input type="number" min="1" name="divers[]" readonly aria-label="divers" class="form-control form-control-sm" placeholder="Divers" value="{{ $content->divers_value }}"></td>
        <td><input type="number" min="1" readonly name="vat_import[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="{{ $content->vat_import_value }}"></td>
        <td><input type="number" min="1" name="total_import[]" readonly aria-label="total_import" class="form-control form-control-sm" placeholder="Total" value="0"></td>
        <td><input type="number" min="1" onchange="calculateVatExport(this)" onkeyup="calculateVatExport(this)" name="export_amount[]" aria-label="export_amount" class="form-control form-control-sm" placeholder="Hors TVA" value="{{ $content->local_amount_value }}" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" name="vat_export[]" readonly aria-label="vat_export" class="form-control form-control-sm" placeholder="TVA" value="{{ $content->local_vat_value }}"></td>
        <td><input type="number" min="1" name="total_export[]" readonly aria-label="total_export" class="form-control form-control-sm" placeholder="Total" value="0"></td>
        <td><input type="number" min="1" name="total_general[]" aria-label="total_general" onkeyup="checkEnterPress(this, event, '{{ route('expectations.store') }}', '{{ csrf_token() }}', '{{ $expectation->session_code }}');" class="form-control form-control-sm" placeholder="Total général" value="0" onclick="setFocus(this)"></td>
    </tr>

    @endforeach
    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ajouter une description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group-lg">
                    <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" placeholder="description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Enregistrer et Fermer</button>
            </div>
        </div>
    </div>
</div>



