clear();

const films = [
  {
    title: 'The Green Mile',
    creationYear: 1999,
    country: ['USA'],
    budget: '$60 000 000',
    actors: [
      {
        name: 'Tom Hanks',
        age: 63,
        role: 'Paul Edgecomb',
      },
      {
        name: 'David Morse',
        age: 65,
        role: 'Brutus Howell',
      },
      {
        name: 'Michael Clarke Duncan',
        age: 54,
        role: 'John Coffey',
      },
    ],
    director: {
      name: 'Frank Darabont',
      age: 60,
      oscarsCount: 0,
    }
  },
  {
    title: 'Inception',
    creationYear: 2010,
    country: ['USA'],
    budget: '$160 000 000',
    actors: [
      {
        name: 'Leonardo DiCaprio',
        age: 44,
        role: 'Cobb',
      },
      {
        name: 'Joseph Gordon-Levitt',
        age: 38,
        role: 'Arthur',
      },
      {
        name: 'Ellen Page',
        age: 32,
        role: 'Ariadne',
      },
      {
        name: 'Tom Hardy',
        age: 41,
        role: 'Eames',
      },
    ],
    director: {
      name: 'Christopher Nolan',
      age: 48,
      oscarsCount: 0,
    }
  },
  {
    title: 'Forrest Gump',
    creationYear: 1994,
    country: ['USA'],
    budget: '$55 000 000',
    actors: [
      {
        name: 'Tom Hanks',
        age: 63,
        role: 'Forrest Gump',
      },
      {
        name: 'Robin Wright',
        age: 53,
        role: 'Jenny Curran',
      },
      {
        name: 'Sally Field',
        age: 72,
        role: 'Mrs. Gump',
      },
    ],
    director: {
      name: 'Robert Zemeckis',
      age: 68,
      oscarsCount: 1,
    }
  },
  {
    title: 'Interstellar',
    creationYear: 2014,
    budget: '$165 000 000',
    country: ['USA','Great Britain', 'Canada'],
    actors: [
      {
        name: 'Matthew McConaughey',
        age: 49,
        role: 'Cooper',
      },
      {
        name: 'Anne Hathaway',
        age: 36,
        role: 'Brand',
      },
      {
        name: 'Jessica Chastain',
        age: 42,
        role: 'Murph',
      },
      {
        name: 'Michael Caine',
        age: 86,
        role: 'Professor Brand',
      },
      {
        name: 'Matt Damon',
        age: 48,
        role: 'Mann',
      },
    ],
    director: {
      name: 'Christopher Nolan',
      age: 48,
      oscarsCount: 0,
    }
  },
  {
    title: 'Catch Me If You Can',
    creationYear: 2002,
    budget: '$52 000 000',
    country: ['USA', 'Canada'],
    actors: [
      {
        name: 'Tom Hanks',
        age: 63,
        role: 'Carl Hanratty',
      },
      {
        name: 'Leonardo DiCaprio',
        age: 36,
        role: 'Frank Abagnale Jr.',
      },
      {
        name: 'Christopher Walken',
        age: 76,
        role: 'Frank Abagnale',
      },
      {
        name: 'Amy Adams',
        age: 44,
        role: 'Brenda Strong',
      },
    ],
    director: {
      name: 'Steven Spielberg',
      age: 72,
      oscarsCount: 4,
    }
  },
];

/*
 * Поиск для object.property1.property2 
 */
function search2st (object, selector, symbol, value)
{   let resultArr = [];
    let index = selector.indexOf(".");
    let selectorNow = selector.substr(0,index);
    let selectorNext = selector.substr(index);
    selectorNext = selectorNext.replace(".","");
    selectorNow = selectorNow.replace(".","");
    for (let key in object){
        switch (symbol){
                case '=':
                if (object[key][selectorNow][selectorNext] == value){
                resultArr[key] = object[key];
                }
                case '<':
                bool = eval(object[key][selectorNow][selectorNext] < value);    
                if (bool){
                resultArr[key] = object[key];
                }
        }
    }
    return resultArr;
}

/*
 * Поиск для object.property
 */
function search1st (object, selector, symbol, value)
{   resultArr = [];
    for (let key in object){
        switch (symbol){
                case '=':
                if (object[key][selector] == value){
                resultArr[key] = object[key];
                }
                case '>':
                bool = eval(object[key][selector] >= value);
                if (bool){
                resultArr[key] = object[key];
                }
        }
    }
    return resultArr;
}

/*
 * Поиск для object.property1[many][property2[many]
 */
function search3st (object, selector, symbol, value)
{   
    let resultArr = [];
    let index = selector.indexOf(".");
    let selectorNow = selector.substr(0,index);
    let selectorNext = selector.substr(index);
    selectorNext = selectorNext.replace(".","");
    selectorNow = selectorNow.replace(".","");
    resultArr = [];
    for (let key in object){
        for (let key1 in object[key][selectorNow]){
        switch (symbol){
                case '=':
                if (object[key][selectorNow][key1][selectorNext] == value){
                resultArr[key] = object[key];
                }
        }
    }
    }
    return resultArr;
}


/*
 * Средний возраст актёров которые снимались в фильмах режисёра , которые не получили оскар
 */

messageOne = search2st (films, 'director.oscarsCount', '<', 1);
age =0;
counter = 0;
for (let key in messageOne){
    for (let key1 in messageOne[key].actors){
    age += messageOne[key].actors[key1].age;
    counter++;
    }
}
ageMiddle = age/counter;
alert ('Средний возраст актёров которые снимались в фильмах режисёра , которые не получили оскар'+ageMiddle);


/*
 * Имена всех актёров которые  играли с Томом Хэнксом, в фильмах после 1995 года
 */
names ='';
messageTwo = search1st(films, 'creationYear', '>', 1995);
console.log(messageTwo);
messageTwo = search3st(messageTwo, 'actors.name', '=', 'Tom Hanks');
console.log(messageTwo);
for (let key in messageTwo){
    for (let key1 in messageTwo[key].actors){
    names += messageTwo[key].actors[key1].name+'\r ';
    }
}
names = names.replace(/Tom Hanks/g, '');
alert ('Имена всех актёров которые  играли с Томом Хэнксом, в фильмах после 1995 года'+names);


/*
 * Общий бюджет , с режисёрами младше 70 лет, в которых не играл том хэнкс
 */
budget = 0;
messageThree = search2st(films, 'director.age', '<', 70);
for (let key in messageThree){
    function checkNames (value) {
        return value.name !=  'Tom Hanks';
    }
    if(messageThree[key].actors.every(checkNames)) {
        console.log(messageThree[key]);
        messageThree[key].budget.replace(' ','');
        budget += parseInt(messageThree[key].budget.replace('$',''));
    }
}
alert('Общий бюджет , с режисёрами младше 70 лет, в которых не играл том хэнкс'+budget);