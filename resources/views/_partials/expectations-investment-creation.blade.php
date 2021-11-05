<table class="table table-sm table-bordered" style="font-size: 10px; width: 100%">
    <thead>
    <tr>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 4%">MOIS DE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 7%">CATEGORIE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 11%">LIBELLE</td>
        <td rowspan="3" colspan="1" class="align-middle text-center" style="width: 2%">DETAILS</td>
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
        <td colspan="17" class="align-content-end">
            <a href="{{ route('expectations.index') }}" class="btn btn-sm btn-secondary"><span class="fa fa-clock"></span> Fermer</a>
        </td>
    </tr>
    </tfoot>
    <tbody>

    <tr>
        <td>
            <select aria-label="period" name="_period[]" class="form-control form-control-sm">
                <option value="">...</option>
                @foreach($months as $item => $value) {
                <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </td>
        <td>

            <input type="hidden" name="line_default_cif_percent[]">
            <input type="hidden" name="line_default_divers_percent[]">
            <input type="hidden" name="line_default_import_vat_percent[]">
            <input type="hidden" name="line_default_export_vat_percent[]">

            <select aria-label="category" name="category[]" class="form-control form-control-sm">
                <option value="">Sélectionner..</option>
                @foreach($categories as $item) {
                <option value="{{ $item->code }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select aria-label="label" name="label[]" class="form-control form-control-sm"></select>
        </td>
        <td class="align-middle text-center">
            <a class="link-dark" style="cursor: pointer" onmouseover="showInfoBull(this)" onclick="return setDescription(this)"  data-toggle="modal" data-target="#staticBackdrop">
                <strong>Ajouter</strong>
            </a>
            <input type="hidden" name="description[]" aria-label="description">
            <input type="hidden" name="entity[]" aria-label="entity">
        </td>
        <td><input type="number" min="1" name="quantity[]" aria-label="quantity" class="form-control form-control-sm" placeholder="Quantité" value="0"></td>
        <td>
            <select aria-label="unit" name="unit[]" class="form-control form-control-sm">
                <option value="">Sélectionner..</option>
                @foreach($units as $item) {
                <option value="{{ $item->code }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" min="1" onkeyup="calculateBankAndDiverseFees(this)" name="cif_value[]" aria-label="cif" class="form-control form-control-sm" placeholder="CIF" value="0" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" readonly name="bank_fees[]" aria-label="bank_fees" class="form-control form-control-sm" placeholder="Frais bancaire" value="0"></td>
        <td><input type="number" min="1" onchange="calculateCifAmountBankFees(this)" onkeyup="calculateCifAmountBankFees(this)" name="cif_percent[]" aria-label="cif_percent" class="form-control form-control-sm" placeholder="% CIF" value="0" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" name="cif_amount[]" readonly aria-label="amount" class="form-control form-control-sm" placeholder="Montant" value="0"></td>
        <td><input type="number" min="1" name="divers[]" readonly aria-label="divers" class="form-control form-control-sm" placeholder="Divers" value="0"></td>
        <td><input type="number" min="1" readonly name="vat_import[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0"></td>
        <td><input type="number" min="1" name="total_import[]" readonly aria-label="total_import" class="form-control form-control-sm" placeholder="Total" value="0"></td>
        <td><input type="number" min="1" onchange="calculateVatExport(this)" onkeyup="calculateVatExport(this)" name="export_amount[]" aria-label="export_amount" class="form-control form-control-sm" placeholder="Hors TVA" value="0" onclick="setFocus(this)"></td>
        <td><input type="number" min="1" name="vat_export[]" readonly aria-label="vat_export" class="form-control form-control-sm" placeholder="TVA" value="0"></td>
        <td><input type="number" min="1" name="total_export[]" readonly aria-label="total_export" class="form-control form-control-sm" placeholder="Total" value="0"></td>
        <td><input type="number" min="1" name="total_general[]" aria-label="total_general" onkeyup="checkEnterPress(this, event, '{{ route('expectations.store') }}', '{{ csrf_token() }}', '{{ $__token }}');" class="form-control form-control-sm" placeholder="Total général" value="0" onclick="setFocus(this)"></td>
    </tr>
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
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="invest">Entité</label>
                        <select name="entity" id="invest" class="form-control">
                            <option value="">Selectionner...</option>
                            @foreach($entities as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="load_investment_details">

                </div>
                <div class="form-group-lg">
                    <textarea aria-label="description" name="desc" id="desc" cols="30" rows="10" class="form-control" placeholder="description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Enregistrer et Fermer</button>
            </div>
        </div>
    </div>
</div>



