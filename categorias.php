<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <style>
        div#categorias{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            justify-content: space-evenly;
        }
        div#categorias a{
            margin: 20px;
            width: 300px;
            padding: 10px;
            text-decoration: none;
            background-color: #292d3e;
            transition: 0.5s;
        }
        div#categorias a:hover {
            background-color: #6d4fa7;
        }
        div#categorias img {
            width: 100%;
        }
        div#categorias h4{
            text-align: center;
            color: white;
            margin: 5px;
        }
    </style>
</head>

<body>
     <div id="titulo">

     </div>

     <div id="carrito">

     </div>

     <div id="categorias">
        <a href="" class="categoria">
            <h4>EJEMPLO</h4>
        </a>

     </div>
</body>
</html>