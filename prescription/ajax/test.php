<!DOCTYPE "html">
<html>
    <head>

        <script type="text/javascript" language="Javascript">
            function test(){
                alert();
                draw();
            }
            function draw(){
                var canvas = document.getElementById("test");
                var ctx = canvas.getContext("2d");
                
                ctx.fillStyle = "#000";
                ctx.strokeRect(100, 100, 100, 100);
                ctx.strokeRect(100, 210, 0, 40);
                ctx.strokeRect(100, 250, 40, 0);
            }
        </script>
    </head>
    <body>
	<button onclick="test()">go</button>
	<canvas width="500" height="500" id="test"></canvas>
        <form action="" method="post" id="form">
            <input type="text" name="hello"/><br/>
            <button onclick="test()">go</button>
        </form>
        <span id="extra">
            <?php
            if(isset($_POST['hello'])){
                echo $_POST['hello'];
            }
            ?>
        </span>
    </body>
</html>
