<form action="{{ route('expectations.store2') }}" method="post">
    @csrf
    <input type="hidden" name="account">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th style="width: 6%" rowspan="2" class="align-middle text-center">MOIS</th>
            <th style="width: 6%" rowspan="2" class="align-middle text-center">PU TTC</th>
            <th style="width: 6%" class="align-middle text-center">TVA <br>
                <input aria-label="vat percent" type="number" id="default_vat" value="16" min="0"  max="16" onbeforeinput="changeDefaultPercents(this.value, 'line_default_vat_percent[]')" onchange="changeDefaultPercents(this.value, 'line_default_vat_percent[]')">
            </th>
            <th style="width: 6%" class="align-middle text-center">ACCISES <br>
                <input aria-label="excise percent" type="number" id="default_excise" value="80" min="0"  max="80" onbeforeinput="changeDefaultPercents(this.value, 'line_default_excise_percent[]')" onchange="changeDefaultPercents(this.value, 'line_default_excise_percent[]')">
            </th>
            <th style="width: 6%" class="align-middle text-center">MàC<br>
                <input aria-label="consumption percent" type="number" id="default_consumption" value="5" min="0"  max="80" onbeforeinput="changeDefaultPercents(this.value, 'line_default_consumption_percent[]')" onchange="changeDefaultPercents(this.value, 'line_default_consumption_percent[]')">
            </th>
            <th rowspan="2" style="width: 2%" class="align-middle text-center">PRI
                <br>
                <input aria-label="investment percent" type="number" id="default_tax" step="any" value="0.75" max="80" onbeforeinput="changeDefaultPercents(this.value, 'line_default_tax_percent[]')" onchange="changeDefaultPercents(this.value, 'line_default_tax_percent[]')">
            </th>
            <th style="width: 6%" class="align-middle text-center">TPI
                <br>
                <input aria-label="industry percent" type="number" id="default_industry" value="2" min="0"  max="2" onbeforeinput="changeDefaultPercents(this.value, 'line_default_industry_percent[]')" onchange="changeDefaultPercents(this.value, 'line_default_industry_percent[]')">
            </th>
            <th class="align-middle text-center">PU HT</th>
            <th class="align-middle text-center">QUANTITE</th>
            <th class="align-middle text-center">D. PAIEMENT</th>
            <th class="align-middle text-center">CA (HT)</th>
            <th class="align-middle text-center">TVA</th>
            <th class="align-middle text-center">ACCISES</th>
            <th class="align-middle text-center">MAC & TPI</th>
            <th class="align-middle text-center">CA (TTC)</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th colspan="15" class="text-right"><button class="btn btn-sm btn-success">Enregistrer</button></th>
        </tr>
        </tfoot>
        <tbody>

        @foreach($months as $item => $value)
            <tr>
                <td>
                    {{ $value }}
                    <input type="hidden" name="_period[]" value="{{ $value }}">

                    <input type="hidden" name="line_default_vat_percent[]">
                    <input type="hidden" name="line_default_excise_percent[]">
                    <input type="hidden" name="line_default_consumption_percent[]">
                    <input type="hidden" name="line_default_tax_percent[]">
                    <input type="hidden" name="line_default_industry_percent[]">
                </td>
                <td>
                    <input onkeyup="calculateUnitPriceAndTaxesReverse(this)" class="form-control form-control-sm" min="0" step="any" required type="number" name="unit_price_final[]" aria-label="unit_price" onclick="setFocus(this)">
                </td>
                <td>
                    <p id="_span_vat{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="vat[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span_excise{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="excise[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span_consumption{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="consumption[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span_tax{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="tax[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span_industry{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="industry[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span_unit_price_final{{$value}}"></p>
                    <input type="hidden" min="0" readonly name="unit_price[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <input type="number" min="0" step="any" onchange="calculateQuantityAndTotals(this)" onkeyup="calculateQuantityAndTotals(this)" name="quantity[]" aria-label="quantity" class="form-control form-control-sm" placeholder="QTE" value="0" onclick="setFocus(this)">
                </td>
                <td>
                    <input type="number" min="0" step="any" name="delivery[]" aria-label="delivery" class="form-control form-control-sm" placeholder="D. Livraison" value="0" onclick="setFocus(this)">
                </td>
                <td>
                    <p id="_span_revenues_wt{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="revenues_wt[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span__vat_final{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="vat_final[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span__excise_final{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="excise_final[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span__consumption_final{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="consumption_final[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
                <td>
                    <p id="_span__revenues{{$value}}"></p>
                    <input type="hidden" min="0"  readonly name="revenues[]" aria-label="vat1" class="form-control form-control-sm" placeholder="TVA" value="0">
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8"><strong>TOTAL</strong></td>
            <td><p id="sum_quantity"></p></td>
            <td></td>
            <td><p id="sum_revenue_wt"></p></td>
            <td><p id="sum_vat"></p></td>
            <td><p id="sum_excise"></p></td>
            <td><p id="sum_consumption"></p></td>
            <td><p id="sum_revenue"></p></td>
        </tr>
        </tbody>
    </table>
</form>
