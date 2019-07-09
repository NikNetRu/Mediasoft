Общее: SQLBuilder предназначени для создания запросов SQL.
Установка: подключить класс SQLBuilder в свой проект.
1. Использование:
    1) Создать обьект SQLBuilder($host, $login, $password, $database);
            Ввод $host, $login, $password, $database - не обязателен
    2) Применить одну из функций определяющих тип запроса:
        insert('you_rtable_name');
        delete('you_rtable_name');
        select('you_rtable_name');
        update('you_rtable_name');
    3) Применить функцию condition;
      ->condoition(array ['your_condition1','your_condition2',..]);
      Обязателен для всех функций определяет условие запроса (например для 
      для insert - ['name = Gimmy', 'age = 19'], select - ['age>10','male = female']
    4) Опционально если применимо:
        применить функцию where(['','','',...])
                          whereOr(['','','',...])
                          orderBy(['','','',...])
                          groupBy(['','','',...])
    5) Применить функцию get() для формирования запроса и его получения в виде строки;
 
2. Выполнение созданного запроса: 
    1) Создать запрос выполнив п.1
    2) Если при создании обьекта $host, $login, $password, $database не вводились:
    применить setQuerrySettings ($host, $login, $password, $database);
    3) Для выполнения запроса executeQuerry ()

3. Вспомогательные команды:
    readResult() - просмотреть результат выполнения запроса
    
        
                        
    
