class Game 
{
    constructor (tableID,strategy) 
    {
        this.status = null;
        this.tableID = tableID;
        this.strategy = strategy;
        self = this;
    }
    /*
     * Вставляет X в ячейку после обтработки события, оно удаляеся
     */
    insertX () 
    {
        this.setAttribute('contain',1);
        this.innerHTML = '&#128939';
        this.removeEventListener('click', this);
    }
    
    generateDocument () {
        document.head.innerHTML = "<style> body \
                                                {background-color: #87CEEB;}</style>";
        let textHello = document.createElement('label');
        textHello.setAttribute('id', 'textHello');
        textHello.innerHTML = 'КРЕСТИКИ-НОЛИКИ';
        document.head.innerHTML += "<style type='text/css'>#textHello\
                                                {font-size: 24px; \n\
                                                 position: absolute; \n\
                                                 right:51%; \n\
                                                 top: 10px; \n\
                                                 color: #FFFAFA; }</style>";
        document.body.appendChild(textHello);
    }
    generateField (x,y) { 
        document.head.innerHTML += "<style type='text/css'>#"+this.tableID+"\
                                                {height: 400px; \n\
                                                 width: 400px;\n\
                                                 position: absolute; \n\
                                                 right:45%; \n\
                                                 top: 50px; \n\
                                                 table-layout: fixed; \n\
                                                 background: #FFF0F5; }</style>";
        document.head.innerHTML += "<style type='text/css'> .cell \n\
                                                 {border: 1px solid black;\n\
                                                  font-size:60px;\n\
                                                  text-align: center;\n\
                                                  height: 33%;}</style>";
        let table = document.createElement("table");       
        table.setAttribute('id',this.tableID);
        table.setAttribute('style','cell');
        document.body.appendChild(table);                  
        let tableHTML = '';                                //в виде текста генерируем таблицу и прикрепляем её.
            for (let i=0; i < x; i++) {
            tableHTML += '<tr>';
                for (let j=0; j<y; j++){
                tableHTML += '<td id = '+'Y'+i+'X'+j+' class = cell></td>';
                }
            tableHTML += '</tr>';
            }
        let tableElem = document.getElementById('table');
        tableElem.innerHTML = tableHTML;
    }
    
    /*
     * Input: tablenameID
     * result: По клику в таблице ЛК записывается Х,
     * и ячейка приобретает свойство contain = 1
     * 
     * путём навешивания обработчиков на ячейки, после дейтсвия,
     * обработчик удаляется
     */
    clickTable ()
    {
        let table = document.getElementById(this.tableID);
        let rowsT = table.rows;
        let XY = '';
            for (let i=0; i < rowsT.length; i++) {
                for (let j=0; j<3; j++){                       
                XY = document.getElementById('Y'+i+'X'+j);
                XY.addEventListener('click', this.insertX);
                XY.setAttribute('contain',0);
                }
        } 
    }
    
    
    /*
     * вставка 0 в свободное поле
     * 
     * random:
     * Устанавливает 0 в рандомное свободное поле,
     * устанавливает совйство contain = -1, для подсчета
     * результата, удаляет обработчик
     * 
     * trueTable:
     * 1) ставим ноль во все ячейки. Если есть вариант завершения игры. СОхраняем 2 в
     * таблицу принятия решения. В прочие ячейки 0,5.
     * 2) Если такового решения нет. Ставим Х во все свободные ячейки. 
     * Если существует вариант решения игры - ставим в эту ячейку 1.
     * 3) Ищем максимум
     */
    
    intellect()
    {   if (this.strategy == 'random'){
            let table = document.getElementById(this.tableID);
            let freeCell = table.querySelectorAll('[contain =\"0\"]');
            let randomNum = parseInt(Math.random()*freeCell.length);
            freeCell[randomNum].innerHTML = '&#128901';
            freeCell[randomNum].setAttribute('contain',-1);
            freeCell[randomNum].removeEventListener('click', self.insertX);
        }
        if (this.strategy == 'trueTable'){
            let trueTable = null;
            let table = document.getElementById('table');
            let freeCell = table.querySelectorAll('[contain =\"0\"]');
            freeCell = Array.from(freeCell);
            
            freeCell.map((cell)=>{
                cell.setAttribute('contain',-1);
                let status = self.checkEndGame(table);
                if (status === 'loose'){
                    console.log('status = '+status);
                    cell.setAttribute('trueTable',2);
                    console.log(cell);
                    cell.setAttribute('contain',0);
                    return;
                }
               cell.setAttribute('contain', 0);
               cell.setAttribute('trueTable',0.5);
               return;
            });
            
            freeCell.map((cell)=>{
                cell.setAttribute('contain', 1);
                let status = self.checkEndGame(table);
                if (status === 'win'){
                    console.log('status = '+status);
                    console.log(cell);
                    cell.setAttribute('contain',0);
                    cell.setAttribute('trueTable',1);
                    return;
               }
               cell.setAttribute('contain',0);
               return;
            });
            
            let push = table.querySelectorAll('[contain =\"0\"]');
            push = Array.from(push);
            let maxTrueTable = Math.max.apply(Math, push.map( (pushCell) => { return pushCell.getAttribute('trueTable'); }));
            console.log('maxTrueTable = ' + maxTrueTable);
            push = table.querySelectorAll(`[trueTable ="${maxTrueTable}"]`,`[ contain =\"0\"]`);
            let randomNum = parseInt(Math.random()*push.length-1);
            console.log(randomNum);
            console.log(push);
            console.log(push[randomNum]);
            push[randomNum].innerHTML = '&#128901';
            push[randomNum].setAttribute('contain',-1);
            push[randomNum].removeEventListener('click', self.insertX);           
            }
        
        }
        
    
    
    /*
     * Проверка на завершение игры.
     * Если все строки, столбы или даигонали в сумме дали 3 для победы Х, 
     * -3 для победы 0.
     * 
     * Для начала создадим матрицу для оценки результата, в которой будут
     * перечислены все значения ХY для счета(поиск по ID), затем по этой матрице осуществлён
     * перебор ячеек и подсчёт свойства contain
     * По идее можно упростить - когда записывается Х ли 0, то нужно сравнивать только смежные
     * ячейки - значения матрицы которые могут завершить игру, а не перебирать все
     */
    checkEndGame (table = document.getElementById('table'))
    {
        let matrix = [['Y0X0','Y0X1','Y0X2'],
                      ['Y1X0','Y1X1','Y1X2'],
                      ['Y2X0','Y2X1','Y2X2'],
                      ['Y0X0','Y1X0','Y2X0'],
                      ['Y0X1','Y1X1','Y2X1'],
                      ['Y0X2','Y1X2','Y2X2'],
                      ['Y0X0','Y1X1','Y2X2'],
                      ['Y2X0','Y1X1','Y0X2']];
        
        let summ = 0;
        for (let i=0; i<matrix.length; i++) {
            for (let j=0; j<3; j++){
                let num = table.querySelectorAll(`[id="${matrix[i][j]}"]`);
                summ += parseInt(num[0].getAttribute("contain"));
            }   
            if (summ == 3) {
                return 'win';
            }
            if (summ == -3) {
                return 'loose';
                
            }
            summ = 0;
        }

    }
    
    /*
     * Основной модуль игры отвечает за последовательность
     */
    engine () 
    {
        this.clickTable();  //навешиваем обработчики
        let table = document.getElementById(this.tableID);
            let listener = () =>
            {
                self.status = self.checkEndGame();
                if (self.status === 'win'){alert('you win');}
                if (self.status === 'loose'){alert('you loose');}   
                self.intellect();
            };
        table.addEventListener('click', listener);
    }
}

gamet = new Game('table','trueTable');
gamet.generateDocument();
gamet.generateField(3,3);
gamet.engine();