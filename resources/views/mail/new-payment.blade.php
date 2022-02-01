<h3>La commande n° {{ $order->external_code }} vient d'enregistrer un paiement !</h3>

<p>Paiement reçu d'un montant de {{ $payment->amount }} {{ strtoupper($payment->currency_code) }}.</p>
<p>
    Référence de la transaction : {{ $payment->external_code }}. <br>
    Veuillez vous connecter pour voir les détails : <a href="{{ route('orders.show', $order_code) }}">CLIQUEZ ICI</a>
</p>
