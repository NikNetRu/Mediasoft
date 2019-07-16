
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head> 
<body>
        <div id ="AddTxt">
            <style>
            textarea {
            width: 60%;
            height: 200px; 
            resize: none;
            } 
    *   *   </style>
            
            <form enctype="multipart/form-data" method="POST" action = "Counter.php" accept-charset="UTF-8">
                <textarea id ="typingTxt" name ="typingTxt">Введите текст</textarea> <br>
                <label>Или загрузите файл</label> <input id = "loadTxt" name = "loadTxt" type="file"> <br>
                <input type = "submit"> <br>
            </form>
            
        </div>
    
</body>