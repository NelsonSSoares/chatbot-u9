<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de ChatBot</title>
    <link rel="stylesheet" href="css/style.css">

    <script>
        var my_time;
		var count = 0;
		setTimeout('pageScroll()', 1200);
		function pageScroll() {
			if (count < 2) {
				var objDiv = document.getElementById("chatbody");
				objDiv.scrollTop = objDiv.scrollTop + 1;
				if (objDiv.scrollTop == (objDiv.scrollHeight - 61)) {
                    setTimeout(function() {
						objDiv.scrollTop = 0;
						count++;
            }, 1200);
				}
				my_time = setTimeout('pageScroll()', 10);
			}
		}
    </script>
</head>

<body>
<div class="container">
    <div class="chatbox">
        <div class="header">
            <h3>Exemplo de ChatBot - <a href="index.php">Reload</a></h3>
            <br>
            <p>Digite <strong>ajuda</strong> para obter a lista de opções.</p>
        </div>
        <div class="body" id="chatbody">
            <div class="scroller"></div>
        </div>

        <a href="#" id="ancora"></a>

        <form class="chat" method="post" autocomplete="off">
            <div>
                <input type="text" name="chat" id="chat" placeholder="Mensagem...">
            </div>
            <div>
                <input type="submit" value="Enviar" id="btn">
            </div>
        </form>
    </div>
</div>

<script>
    window.location.href='#ancora';
</script>

<script src="app.js"></script>

</body>

</html>
