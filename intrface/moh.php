<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p id="par">mohammed</p><br>
    <button id="bott" onclick="change()" >change</button>
    <input type="text" id="k" value="kk">

    <script>
        function change(){

          var element1 = document.getElementById('k');
            var element = document.getElementById('par');
        
            element1.value='mohh';
             element1.style.color = 'red';
          
             let bot =document.getElementById('bott');
             
             bot.addEventListener("click",function(){
                  alert('cc');
             })

        }
    </script>
</body>
</html>