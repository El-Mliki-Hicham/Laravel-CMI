<h1>Payment form CMI</h1>
<form method="post" action="{{route('cmi_pyement')}}">
    @csrf
    <label for="amount">Amount</label>
    <input type="text" name="amount" class="input-control" placeholder="put amount here 10.65" value="10.60"> DHS<br />
    <input type="text" name="facture">

    <button type="submit">Buy</button>
</form>
