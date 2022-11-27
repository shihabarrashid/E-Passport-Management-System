<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <h2 class="text-center">Documents of {{ $application->name }}</h2>

    <img src="{{ public_path("/storage/images/".$document->nid)}}" alt="NID" width="100%">

    <img src="{{ public_path("/storage/images/".$document->birth_certificate)}}" alt="BIRTH CERTIFICATE" width="100%">

    <img src="{{ public_path("/storage/images/".$document->national_certificate)}}" alt="NATIONALITY CERTIFICATE" width="100%">

    @if($document->passport != null)
        <img src="{{ public_path("/storage/images/".$document->passport)}}" alt="PASSPORT" width="100%">
    @endif

    @if($document->go_noc != null)
        <img src="{{ public_path("/storage/images/".$document->go_noc)}}" alt="GO/NOC" width="100%">
    @endif

    @if($document->tin_certificate != null)
        <img src="{{ public_path("/storage/images/".$document->tin_certificate)}}" alt="TIN CERTIFICATE" width="100%">
    @endif 

</body>
</html>