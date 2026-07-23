## Programação funcional com PHP

Este projeto visa explicar os conceitos de programação funcional utilizando o PHP. Ele é apenas um RESUMO do meu entendimento do assunto através dos cursos da Alura ministrados pelo grande [Vinicius Dias](https://www.youtube.com/@DiasDeDev). Para um entendimento completo a respeito do assunto recomendo checar o curso completo através do site da Alura.

## Revisitando Funções

### Tipo Callable

O PHP permite tratar funções como valores. Isso significa que elas podem ser atribuídas a variáveis, passadas como parâmetros para outras funções e retornadas por funções. O tipo responsável por representar qualquer valor que possa ser invocado como uma função é o `callable`, muito utilizado para a criação de callbacks.

```php
<?php

function foo(callable $func): void
{
    echo "Running another function: ";
    echo $func();
}

bar(function () {
    return 'Another function';
});
```

No exemplo acima, criamos uma função `bar()` que recebe um parâmetro do tipo `callable`, ou seja, qualquer valor que possa ser invocado como uma função. Dentro de `bar()`, esse parâmetro é executado utilizando a sintaxe `$func()`. Ela faz um echo de uma string e na sequência executa a função passada como parâmetro. Depois, chamamos esta função criada e declaramos dentro dela uma `função anônima` cujo corpo apenas retorna uma string. Isto faz com que a função `bar()` seja chamada passando como parâmetro a nossa função anônima e, ao executá-la dentro de `bar()`, teremos o retorno da função anônima exibido.

Podemos simplificar a leitura do exemplo atribuindo a função anônima a uma variável e passando essa variável como argumento para `bar()`. O comportamento permanece o mesmo: a variável `$foo` armazena uma função e, quando `bar`() executa `$func()`, a função armazenada em `$foo` é chamada.

```php
<?php

function foo(callable $func): void
{
    echo "Running another function: ";
    echo $func();
}

bar = function() {
    return 'Another function';
};

foo($bar);
```

Observe que a variável `$foo` não armazena o retorno da função, mas sim a própria função. Somente quando executamos `$foo()` (ou `$func()` dentro de `bar()`) é que o seu código é executado.


### Closure

Em PHP uma closure é basicamente uma classe, e essa classe é usada para representar uma função anônima. Portanto, quando criamos uma função anônima, por baixo dos panos o PHP gera um objeto do tipo `closure`.

```php
<?php

$foo = function() {
    return 'Another function';
};

// Este var_dump() irá retornar que $foo é um objeto do tipo Closure
var_dump($foo);
```

Como `Closure` é uma classe, ela possuiu alguns métodos dentro dela que podem ser de grande ajuda. Na [documentação](https://www.php.net/manual/en/class.closure.php) é possível encontrar todos os métodos disponíveis para utilização.

Uma das principais características de uma closure é a capacidade de capturar variáveis do escopo onde ela foi criada, permitindo utilizá-las mesmo quando não pertencem ao escopo da própria função.

Por exemplo, considere o código abaixo:

```php
<?php

$foo = "I'm not a global variable!";

function bar() 
{
    echo $foo;
}
```

Esse código gera um erro, pois funções possuem o seu próprio escopo e a variável `$foo` não está disponível dentro de `bar()`.

Para disponibilizar essa variável para uma função anônima (que por baixo dos panos é uma closure), utilizamos a cláusula `use`, que captura a variável do escopo externo.

```php
<?php

$foo = "I'm not a global variable!";

$bar = function() use($foo) {
    echo $foo;
}
```

### Declarativo vs Imperativo

Vamos considerar que temos um arquivo com alguns países e as suas medalhas numa olimpíada e queremos contar quantos países existem na competição.

```php
<?php

// data.php

return [
    [
    "country" => "Brazil",
        "medals" => [
            "gold" => 3,
            "silver" => 5,
            "bronze" => 10
        ]
    ],
    [
    "country" => "Costa Rica",
        "medals" => [
            "gold" => 10,
            "silver" => 8,
            "bronze" => 13
        ]
    ],
    [
    "country" => "England",
        "medals" => [
            "gold" => 15,
            "silver" => 10,
            "bronze" => 20
        ]
    ],
    [
    "country" => "Saudi Arabia",
        "medals" => [
            "gold" => 10,
            "silver" => 3,
            "bronze" => 2
        ]
    ]    
];

```

Em PHP isto é muito fácil. Basta iniciarmos um contador em 0, fazer um foreach no array e dentro dele incrementar o contador.

```php
<?php

$data = require 'data.php';

$count = 0;

foreach ($data as $country) {
    $count++;
}

echo "The number of countries participating is: $count\n";
```

Na programação imperativa, nos preocupamos em escrever cada passo necessário para resolver um problema, exatamente como no exemplo acima. Já na programação declarativa, descrevemos apenas o que queremos obter. A programação funcional incentiva esse segundo estilo, utilizando funções prontas para realizar grande parte do trabalho.

Veja o exemplo abaixo onde também fazemos a contagem dos países, mas numa abordagem um pouco diferente, utilizando uma função existente dentro do PHP.

```php
<?php

$data = require 'data.php';

$count = 0;

// Passamos o $count como referência, pois iremos alterar o seu valor
array_walk($data, function () use(&$count){
    $count++;
});

echo "The number of countries participating is: $count\n";
```

Nele utilizamos uma função nativa do PHP que percorre um array chamada `array_walk()` e dentro da função anônima que criamos dentro do `array_walk()` fizemos a contagem dos países.

É claro que os dois códigos acima podem ser facilmente substituídos por um simples `count($data);`, mas a ideia aqui é mostrar que podemos abordar o mesmo problema de maneiras diferentes, desde que saibamos quais ferramentas utilizar ao nosso favor.

## Manipulando Arrays

### Mapeando Dados

Vamos utilizar o array de países criado anteriormente e modificar o valor da chave country, deixando o nome de cada país em letras maiúsculas. Temos algumas opções:

- Usar um foreach, mas neste caso teríamos que utilizar referências para alterar os elementos do array original.
- Usar um for, para iterar sob cada chave do array.
- Utilizar uma abordagem mais declarativa, mapeando os elementos do array e informando apenas qual transformação desejamos aplicar.

Aqui, por se tratar de um conteúdo baseado no paradigma funcional, vamos utilizar a abordagem número três, utilizando a função `array_map()` do PHP.

```php
<?php

$data = require 'data.php';

$modifiedArray = array_map(function (array $data) {
    $data['country'] = strtoupper($data['country']);
    return $data;
}, $data);

var_dump($modifiedArray);
```

O `array_map()` percorre todos os elementos do array recebido como parâmetro. Para cada elemento, ele executa a função informada e utiliza o valor retornado por essa função para montar um novo array. Neste exemplo, cada elemento do array é recebido pela função anônima na variável `$data`. Alteramos o valor da chave country utilizando `strtoupper()` e retornamos o elemento modificado. Ao final da execução, o `array_map()` devolve um novo array contendo todas essas alterações. 

Neste exemplo armazenamos o resultado em uma nova variável `$modifiedArray`. Embora seja possível sobrescrever o array original, criar um novo array é uma prática comum na programação funcional, pois evita modificar os dados originais.


### Filtrando o array

Agora vamos abordar um problema um pouco mais complexo que os anteriores. Vamos dizer que queremos filtrar o nosso array de países e exibir somente países que possuam um espaço em seu nome. Utilizando a abordagem funcional, podemos fazer uma função que verifica se a string possue um espaço e usar o `array_filter()` para salvar esses dados.

```php
<?php

$data = require 'data.php';

function checkIfCountryHasSpaceInTheName(array $country): bool {
    return str_contains($country['country'], ' ');
}

$data = array_filter($data, 'checkIfCountryHasSpaceInTheName');

var_dump($data);
```

Basicamente criamos uma função que checa se a string contém algum valor (no nosso caso um espaço em branco) e retornamos o resultado dessa validação. Quando chamamos o `array_filter()` informando o nosso array e a função que criamos, ele percorre o array e filtra ele usando a validação que criamos. Portanto, `$data` será agora um array contendo apenas os países que atendem a validação que criamos acima.













