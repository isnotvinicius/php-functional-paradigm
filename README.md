## Programação funcional com PHP

Este projeto visa explicar os conceitos de programação funcional utilizando o PHP. Ele é apenas um RESUMO do meu entendimento do assunto através dos cursos da Alura ministrados pelo grande [Vinicius Dias](https://www.youtube.com/@DiasDeDev). Para um entendimento completo a respeito do assunto recomendo checar o curso completo através do site da Alura.


### Tipo Callable

O PHP permite tratar funções como valores. Isso significa que elas podem ser atribuídas a variáveis, passadas como parâmetros para outras funções e retornadas por funções. O tipo responsável por representar qualquer valor que possa ser invocado como uma função é o `callable`, muito utilizado para a criação de callbacks.

```php
<?php

function bar(callable $func): void
{
    echo "Running another function: ";
    echo $func();
}

bar(function () {
    return 'Another function';
});
```

No exemplo acima, criamos uma função `bar()` que recebe um parâmetro do tipo `callable`, ou seja, qualquer valor que possa ser invocado como uma função. Dentro de `bar()`, esse parâmetro é executado utilizando a sintaxe `$func()`. Ela faz um echo de uma string e na sequência executa a função passada como parâmetro. Depois, chamamos esta função criada e declaramos dentro dela uma `função anônima` cujo corpo apenas retorna uma string. Isto faz com que a função `bar()` seja chamada passando como parâmetro a nossa função anônima e, ao executá-la dentro de `bar()`, teremos o retorno da função anônima exibido.

Podemos simplificar a leitura do exemplo atribuindo a função anônima a uma variável e passando essa variável como argumento para `bar()`. O comportamento permanece exatamente o mesmo: a variável `$foo` armazena uma função e, quando `bar`() executa `$func()`, a função armazenada em `$foo` é chamada.

```php
<?php

function bar(callable $func): void
{
    echo "Running another function: ";
    echo $func();
}

$foo = function() {
    return 'Another function';
};

bar($foo);
```

Observe que a variável `$foo` não armazena o retorno da função, mas sim a própria função. Somente quando executamos `$foo()` (ou `$func()` dentro de `bar()`) é que o seu código é executado.
