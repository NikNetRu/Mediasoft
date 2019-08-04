/*
 * создёт блок div(id = field), 
 * внутри него table(id = table) 
 */
function generateField (x,y) 
{   
    fieldCreate = document.createElement("div"); //создаём элемент div в котором будет хранится таблица
    fieldCreate.setAttribute('id', 'field');     //устанавливаем для него свойства id = field
    document.body.appendChild(fieldCreate);      //Инициализация созданного элемента в документ и добавим пару стилей для таблицы
    document.head.innerHTML += "<style type='text/css'> table {height: 400px; width: 400px;background: grey; }</style>";
    document.head.innerHTML += "<style type='text/css'> td,th {border: 1px solid black;}</style>";
    fieldElem = document.getElementById('field');  // fieldElem - ссылка на наш div - field
    table = document.createElement("table");       //создаём таблицу table и храним ссылку в переменной table
    table.setAttribute('id','table');
    table.setAttribute('style','cell');
    fieldElem.appendChild(table);                  
    tableHTML = '';                                //в виде текста генерируем таблицу и прикрепляем её.
    for (i=0; i < x; i++) {
        tableHTML += '<tr>';
        for (j=0; j<y; j++){
            tableHTML += '<td id = '+'Y'+i+'X'+j+'></td>';
        }
        tableHTML += '</tr>';
    }
    tableElem = document.getElementById('table');
    tableElem.innerHTML = tableHTML;
}

generateField(3,3);