class Game 
{
    constructor (tableID) 
    {
        this.status = null;
        this.tableID = tableID;
    }
    /*
     * Вставляет X в ячейку после обтработки события, оно удаляеся
     */
    insertX () 
    {
        this.setAttribute('contain',1);
        this.innerHTML = 'X';
        this.removeEventListener('click', this);
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
            for (i=0; i < rowsT.length; i++) {
                for (j=0; j<3; j++){                        //!!!
                XY = document.getElementById('Y'+i+'X'+j);
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
    {
        let table = document.getElementById(this.tableID);
        let freeCell = table.querySelectorAll('[contain =\"0\"]');
        let randomNum = parseInt(Math.random()*freeCell.length);
        freeCell[randomNum].innerHTML = '0';
        freeCell[randomNum].setAttribute('contain',-1);
        freeCell[randomNum].removeEventListener('click', this.insertX);
        
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
        for (i=0; i<matrix.length; i++) {
            for (j=0; j<3; j++){
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
                this.checkEndGame();
                this.intellect();
            };
        table.addEventListener('onchange', listener);
    }
}

gamet = new Game('table');
gamet.engine();