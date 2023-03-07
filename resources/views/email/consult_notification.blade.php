<!DOCTYPE html>
<html>
<head>
    <title>Consultation</title>
</head>
<body>
    <header>
    <div align="center">
    <h1>Consultation Result</h1>
    <p class="fst-italic">AcmeClinic Inc.</p>
    </div>
    <div>
    <p>Customer Name: <strong>{{ $pet->lname }} {{ $pet->fname }}</strong></p>    
    <p style="margin:0;display:inline;float:left">Pet Name: <strong>{{ $pet->name }}</strong></p>
    <p style="margin:0;display:inline;float:right">Date: {{ $pet->created_at }}</p>
    </div>
    </header>
    <div class="container">
    <br>
<hr style="border: 0.5px solid black;">
    <div class="container">
        <p><strong>Diseases/Pet Injuries:</strong>
        @foreach($consultations as $consultation)
             @foreach($consultation->conditions as $condition)
              <li>{{ ($condition->description) }}</li></p>
             @endforeach
        @endforeach
    	<p><strong>Vet Comment:</strong> {{ $pet->comment }}</p>
    	<p><strong>Price of Consultation:</strong> {{ $pet->price }}</p>
    </div>
<hr style="border: 2px solid black;">
<footer>
    <div align="center" class="d-grid gap-1">
    <p class="fw-semibold">Thanks for supporting local business!</p>
    <p class="fst-italic">For any doubts you can contact us at AcmeClinic@clinic.ph</p>
    </div>
    </div>
</footer>
{{--         <hr style="border: 2px solid black;">

        <hr style="border: 2px solid black;"> --}}
</body>
</html>