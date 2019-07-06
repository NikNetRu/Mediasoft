
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

a = parseFloat(result.operands[0]);
alert(a);
b = parseFloat(result.operands[1]);
alert(b);
alert(result.operators);
switch (result.operators) {
        case '*': alert(a*b);
        case '/': alert(a/b);
        case '': alert(a+b);
        case null: alert(a+b);
};
}
   alert(eval(ab)); //основной метод 
   Delimetr(ab);    //альтернатива
    clear();
        
