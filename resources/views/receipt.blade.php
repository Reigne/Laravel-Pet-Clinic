<!DOCTYPE html>
<html>
<head>

    <title>Receipt</title>
</head>
<body>
    <header>
    <div align="center">
    <h1>{{ $title }}</h1>
    <p class="fst-italic">AcmeClinic Inc.</p>
    </div>
    <div>
    <p style="margin:0;display:inline;float:left">Customer Name: <strong>{{ $name }}</strong></p>
    <p style="margin:0;display:inline;float:right">Date: {{ $date }}</p>
    </div>
    </header>
 <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Service</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody class="table-group-divider">
    @foreach ($orders as $order)
    <tr>
      <th scope="row">{{ $order->id }}</th>
      <td>{{ $order->description }}</td>
      <td>${{ $order->price }}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="2" align="right"><strong>Grandtotal:</strong></td>
        <td><strong>${{ $total }}</strong></td>
    </tr>
    <tr>
  </tbody>
</table>

<hr style="border: 2px solid black;">
<footer>
    <div align="center" class="d-grid gap-1">
    <p class="fw-semibold">Thanks for supporting local business!</p>
    <p class="fst-italic">For any doubts you can contact us at AcmeClinic@clinic.ph</p>
    </div>
</footer>
{{--         <hr style="border: 2px solid black;">

        <hr style="border: 2px solid black;"> --}}

</body>
</html>