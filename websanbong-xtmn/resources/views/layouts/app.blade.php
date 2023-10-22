<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="background-color: blue ; color:aliceblue">
        <h1>header</h1>
    </div>
    @yield('content')
    <div style="background-color:black; color:aliceblue">
        <h1>footer</h1>
    </div>
</body>
</html>