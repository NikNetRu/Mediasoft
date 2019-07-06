 
 
/*
 * без eval. Not Work
 * Логика работы:
 * 1 Проходимся по строке ища определённые совпадения - для этого реализована функция 
 * SearchAndDEl.
 *          1.1 ПО шаблону ищем все подобия -[(*какие то значения*),знак*число*умножение/деление*знак*число]
 *          1.2. Если совпадения первого шаблона есть отправляем повторно на поиск совпадения этого же шаблона [0]
 *          1.3. Если совпадения нет ищем в полученном выражении второй шаблон
 * 2. Начинаем в обратном порядке выполнять действия с помощью функций:
 * Delimetr - для отделения знаком от числел
 * Execute для их выполнения
 *          2.1. Находим все совпадения  п.1.3. и проводим итерации.
 *          2.2. В обратном порядке проводим: умножение, деление, выражения в скобках, затем суммируем или вычитаем.
 *          
 */
ab = prompt('Введите что посчитать, например 8+5, или 4.2/2', '');
/*
 * Получает строку вида *число*знак*число*знак.. и возвращает обект типа:
 *  со свойствами - *Object*.operands, *Object*.operators, *Object*.string 
 *  где operands и operators -  массивы операндов, все знаки хранятся с числами (+7,-6)
 *  а все знаки *, / вынесены в операторы, скобки то же
 *  Свойства operands и operators наследуют от match
 */


function Delimetr (string) {
let result = new Object();
let operands;
let operators;
rexp = new RegExp(/[+]{0,2}[-]{0,2}[0-9.]+/,'g');
operands = string.match(rexp);
rexp = new RegExp(/[^0-9.+-]+/,'g');
operators = string.match(rexp);
result.operands = operands;
result.operators = operators;
return result;
}
/*
 * Находим куски выражений по паттерну удаляем их из искомого выражения
 */
function SearchAndDel (string, pattern) {
    let result = new Object(); 
    rexp = new RegExp(pattern);
    frase = string.match(rexp);
    result.frase = [];
    result.frase = frase;
    //вырежем фразу занесённую в свойство frase
    result.string = string.slice[frase.index, frase.index+frase.length];
    return result;
}


/*
 * 
 * Исполняем куски выражениия,  symbol - операция
 */
function Execute (a,b,symbol) {
    switch (symbol) {
        case '*': return a*b;
        case '/': return a/b;
        case '': return a+b;
        case NULL: return a+b; 
    }
        
}


pattern = [/[+]{0,1}[-]{0,1}[(]{1}[0-9\\.+\\-\\*]+[)]/,
    /[+]{0,2}[-]{0,2}[0-9.]+[*/][+]{0,2}[-]{0,2}[0-9.]/,
    /[+]{0,2}[-]{0,2}[0-9.]+[+-][+]{0,2}[-]{0,2}[0-9.]/];
pattern =[/[+]{0,2}[-]{0,2}[0-9.]+/];


/*
 */

function Realizer (string, pattern){
    result = 0;
    frases =[];
    i =0;
    j=0;
    //проходимся по знакам удаляя их из результирующего массива вместе с операндами
    while (i<pattern.length){
        frases += RecurseSearchPattern(string,pattern[i]);
        alert(frases);
        function RecurseSearchPattern (string,pattern) {
        while(string.search(pattern)){
            resultSearh = SearchAndDel(string,pattern);
            alert(resultSearh);
            result = RecurseSearchPattern(resultSearh.string);
            return result;
        }
        };
        i++;
    }
    
        return frases;
}



alert(Realizer(ab,pattern));
clear();
