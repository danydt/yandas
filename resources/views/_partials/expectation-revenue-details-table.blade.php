<table class="table table-sm table-bordered" style="font-size: 12px">
    <thead>
    <tr>
        <th rowspan="2" class="align-middle text-center" >MOIS</th>
        <th rowspan="2" class="align-middle text-center" >PU HT</th>
        <th colspan="2" class="align-middle text-center" >TVA</th>
        <th colspan="2" class="align-middle text-center" >ACCISES</th>
        <th colspan="2" class="align-middle text-center" >MàC</th>
        <th rowspan="2" class="align-middle text-center" >PRI</th>
        <th colspan="2" class="align-middle text-center" >TPI</th>
        <th rowspan="2" class="align-middle text-center" >PU TTC</th>
        <th rowspan="2" class="align-middle text-center" >Quantité</th>
        <th rowspan="2" class="align-middle text-center" >CA (HT)</th>
        <th rowspan="2" class="align-middle text-center" >TVA</th>
        <th rowspan="2" class="align-middle text-center" >Accises</th>
        <th rowspan="2" class="align-middle text-center" >MAC & TPI</th>
        <th rowspan="2" class="align-middle text-center" >CA (TTC)</th>
    </tr>
    <tr>
        <th class="align-middle text-center" >Taux</th>
        <th class="align-middle text-center" >USD</th>
        <th class="align-middle text-center" >Taux</th>
        <th class="align-middle text-center" >USD</th>
        <th class="align-middle text-center" >Taux</th>
        <th class="align-middle text-center" >USD</th>
        <th class="align-middle text-center" >Taux</th>
        <th class="align-middle text-center" >USD</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_quantity = [];
        $total_revenue_wt = [];
        $total_vat = [];
        $total_excise = [];
        $total_consumption = [];
        $total_industry = [];
        $total_revenue = [];

        $total_all_quantity = [];
        $total_all_revenue_wt = [];
        $total_all_vat = [];
        $total_all_excise = [];
        $total_all_consumption = [];
        $total_all_revenue = [];
    @endphp
    @forelse($expectation->revenues as $index => $item)
        <tr>
            <td>{{ $item->month_code }}</td>
            <td class="text-right">
                {{ number_format($item->unit_price, 1, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->vat_percent, 0, ',', ' ') }}%
            </td>
            <td class="text-right">
                {{ number_format($item->vat_amount, 2, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->excise_percent, 0, ',', ' ') }}%
            </td>
            <td class="text-right">
                {{ number_format($item->excise_amount, 2, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->consumption_percent, 0, ',', ' ') }}%
            </td>
            <td class="text-right">
                {{ number_format($item->consumption_amount, 2, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->tax_amount, 2, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->industry_percent, 0, ',', ' ') }}%
            </td>
            <td class="text-right">
                {{ number_format($item->industry_amount, 2, ',', ' ') }} $
            </td>
            <td class="text-right">

                @php
                    $unit_price = $item->vat_amount +  $item->excise_amount +  $item->consumption_amount +  $item->industry_amount +  $item->unit_price
                @endphp

                {{ number_format($unit_price, 2, ',', ' ') }} $
            </td>
            <td class="text-right">
                {{ number_format($item->quantity, 2, ',', ' ') }}
                @php
                    array_push($total_quantity, $item->quantity);
                @endphp
            </td>
            <td class="text-right">

                @php
                    $total_revenue_wt = $item->quantity *  $item->unit_price
                @endphp

                {{ number_format($total_revenue_wt, 2, ',', ' ') }} $

                @php
                    array_push($total_all_revenue_wt, $total_revenue_wt);
                @endphp
            </td>
            <td class="text-right">

                @php
                    $total_vat = $item->quantity *  $item->vat_amount
                @endphp

                {{ number_format($total_vat, 2, ',', ' ') }} $

                @php
                    array_push($total_all_vat, $total_vat);
                @endphp
            </td>
            <td class="text-right">

                @php
                    $total_excise = $item->quantity *  $item->excise_amount
                @endphp

                {{ number_format($total_excise, 2, ',', ' ') }} $

                @php
                    array_push($total_all_excise, $total_excise);
                @endphp
            </td>
            <td class="text-right">

                @php
                    $total_consumption = $item->quantity *  ($item->consumption_amount + $item->industry_amount)
                @endphp

                {{ number_format($total_consumption, 2, ',', ' ') }} $

                @php
                    array_push($total_all_consumption, $total_consumption);
                @endphp
            </td>
            <td class="text-right">

                @php
                    $total_revenue = $total_all_revenue_wt[$index] + $total_all_vat[$index] + $total_all_excise[$index] + $total_all_consumption[$index]
                @endphp

                {{ number_format($total_revenue, 2, ',', ' ') }} $

                @php
                    array_push($total_all_revenue, $total_revenue);
                @endphp
            </td>
        </tr>
        @empty
    @endforelse
    <tr>
        <td colspan="12">TOTAL</td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_quantity), 2, ',', ' ') }}</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_revenue_wt), 2, ',', ' ') }} $</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_vat), 2, ',', ' ') }} $</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_excise), 2, ',', ' ') }} $</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_consumption), 2, ',', ' ') }} $</strong></td>
        <td class="text-right"><strong>{{ number_format(array_sum($total_all_revenue), 2, ',', ' ') }} $</strong></td>
    </tr>
    </tbody>
</table>
