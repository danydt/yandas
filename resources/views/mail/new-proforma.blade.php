<h3>Encore une bonne nouvelle {{ $username }} !</h3>

<p>La facture proforma pour votre commande est maintenant disponible.</p>
<p>Veuillez vous connecter pour voir les détails : <a href="{{ route('orders.show', $order_code) }}">CLIQUEZ ICI</a></p>
