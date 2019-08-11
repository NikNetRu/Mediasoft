class Game 
{
    constructor (tableID,strategy) 
    {
        this.status = null;
        this.tableID = tableID;
        this.strategy = strategy;
        this.lastX = null;
        self =this;
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
                for (let j=0; j<3; j++){                        //!!!
                XY = document.getElementById('Y'+i+'X'+j);
                this.lastX = {'Y':i,
                              'X': j};
                XY.addEventListener('click', this.insertX);
                XY.setAttribute('contain',0);
                }
        } 
    }
    
    
    /*
     * вставка 0 в свободное поле
     * пока рандомно потом можно дописать
     * Устанавливает 0 в рандомное свободное поле,
     * устанавливает совйство contain = -1, для подсчета
     * результата, удаляет обработчик
     */
    intellect()
    {   if (this.strategy == 'random'){
        let table = document.getElementById(this.tableID);
        let freeCell = table.querySelectorAll('[contain =\"0\"]');
        let randomNum = parseInt(Math.random()*freeCell.length);
        freeCell[randomNum].innerHTML = '&#128901';
        freeCell[randomNum].setAttribute('contain',-1);
        freeCell[randomNum].removeEventListener('click', this.insertX);
        }
        if (this.strategy == 'vector'){
        let table = document.getElementById(this.tableID);
        let freeCell = table.querySelectorAll('[contain =\"0\"]');
        let vectorX = parseInt(Math.random()*(2)-1);
        let vectorY = parseInt(Math.random()*(2)-1);
        console.log(vectorX,vectorY);
        this.lastX.X += vectorX;
        this.lastX.Y += vectorY;
        for (let key in freeCell){
            if (freeCell[key].id === 'Y'+this.lastX.Y+'X'+this.lastX.Y){
                console.log(vectorX,vectorY);
                console.log(freeCell[key]);
                freeCell.innerHTML = '&#128901';
                alert('d');
            }
        }
        //let cell = freeCell.querySelector('[id = \"Y'+this.lastY+'X'+this.lastX+'\"]');
        //cell.innerHTML = '&#128901';
        //cell.setAttribute('contain',-1);
        //cell.removeEventListener('click', this.insertX);
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
    checkEndGame ()
    {
        let matrix = [['Y0X0','Y0X1','Y0X2'],
                      ['Y1X0','Y1X1','Y1X2'],
                      ['Y2X0','Y2X1','Y2X2'],
                      ['Y0X0','Y1X0','Y2X0'],
                      ['Y0X1','Y1X1','Y2X1'],
                      ['Y0X2','Y1X2','Y2X2'],
                      ['Y0X0','Y1X1','Y2X2'],
                      ['Y2X0','Y1X1','Y0X2']];
        
        let table = document.getElementById(this.tableID);
        let summ = 0;
        for (let i=0; i<matrix.length; i++) {
            for (let j=0; j<3; j++){
                let num = document.getElementById(matrix[i][j]);
                console.log(num);
                summ += parseInt(num.getAttribute('contain'));
            }   
            if (summ == 3) {
                alert('you win');
                return 'win';
            }
            if (summ == -3) {
                alert('you loose');
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
            let listener = function ()
            {
                self.checkEndGame();
                self.intellect();
            };
        table.addEventListener('click', listener);
    }
}

gamet = new Game('table','random');
gamet.generateDocument();
gamet.generateField(3,3);
gamet.engine();