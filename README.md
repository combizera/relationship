# Relacionamentos no Laravel

Os relacionamentos no Laravel são excelentes para gerenciar e trabalhar com associações entre diferentes tabelas do Banco de Dados.

Criei este repositório para documentar e consolidar meus estudos sobre os relacionamentos no Laravel. Como vim do Front-End, logo percebi necessidade de aprofundar meu entendimento em Back-End, especialmente no Laravel. Ter uma compreensão sólida sobre os relacionamentos entre tabelas além de otimizar meu trabalho também garante que as aplicações sejam bem estruturadas, eficientes e escaláveis.

A ideia é que este repositório sirva tanto como uma referência pessoal quanto uma fonte de consulta para outros devs que queiram entender os relacionamentos no Laravel.

## Índice

- [Informações Gerais](#informações-gerais)
   - [Convenções de Nomenclatura](#convenções-de-nomenclatura)

- [Relacionamentos](#relacionamentos)
   - [HasOne](#hasone)
   - [HasMany](#hasmany)
   - [BelongsTo](#belongsto)
   - [BelongsToMany](#belongstomany)
   - [HasOneThrough](#hasonethrough)
   - [HasManyThrough](#hasmanythrough)

- [Referências e Recursos](#referências-e-recursos)
- [Contribuição](#contribuição)
- [Licença](#licença)

## Informações Gerais

1. Convenções de nomenclatura
   - No Laravel assumimos que a chave estrangeira (FK) terá o nome do Model em `snake_case` seguido de `_id`. Por exemplo, se temos um Model `User`, a chave estrangeira será `user_id`.

---

## HasOne

O relacionamento `HasOne` (TemUm) é usado quando uma Model possui exatamente uma instância de outra Model. Por exemplo, um usuário **tem um** avatar.
    
```php
// App\Models\User.php
public function avatar(): HasOne
{
    return $this->hasOne(Avatar::class);
}

// App\Models\Avatar.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Ou seja, um usuário pode ter *um* avatar e um avatar pertence a um usuário.

---


## HasMany
O relacionamento `HasMany` (TemMuitos) é usado quando uma Model pode ter múltiplas instâncias de outro Model. Por exemplo, um usuário pode ter vários posts.

```php
// App\Models\User.php
public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}

// App\Models\Post.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Ou seja, um usuário pode ter **muitos** posts e um post pertence a um usuário.

---

## BelongsTo

O relacionamento `BelongsTo` (PertenceA) é o inverso de `HasOne` e `HasMany`. É usado quando uma Model pertence a outra Model. Por exemplo, um post pertence a um usuário.

```php
// App\Models\Comment.php
public function post(): BelongsTo
{
    return $this->belongsTo(User::class);
}

// App\Models\Post.php
public function comments(): HasMany
{
    return $this->hasMany(Post::class);
}
```

Ou seja, um comentário pertence a um post e um post pode ter **muitos** comentários.

---

## BelongsToMany

O relacionamento `BelongsToMany` (PertenceAMuitos) é usado quando uma Model pode ter múltiplas instâncias de outra Model e vice-versa. 

```php
// App\Models\Student.php
public function courses(): BelongsToManypa
{
    return $this->belongsToMany(Course::class, 'student_courses');
}

// App\Models\Course.php
public function students(): BelongsToMany
{
    return $this->belongsToMany(Student::class, 'student_courses');
}
```
Ou seja, um estudante pode ter estar matriculado em vários cursos e um curso é capaz de ter vários estudantes matriculados.

---

## HasOneThrough

Usamos o `HasOneThrough` (TemUmAtravés) quando queremos acessar um registro que está indiretamente relacionado através de uma `Model` intermediária. Ele é útil quando um Model está a uma "distância" de outra tabela, e queremos simplificar o acesso.

Primeiro fazemos o relacionamento básico entre as Models `User`, `Address` e `Order`:
```php
// App\Models\User.php
// Um usuário tem muitos pedidos e um endereço
public function orders(): HasMany
{
    return $this->hasMany(Order::class);
}

public function address(): HasOne
{
    return $this->hasOne(Address::class);
}

// App\Models\Order.php
// Um pedido pertence a um usuário
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

// App\Models\Address.php
// Um endereço pertence a um usuário
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Agora, vamos acessar o endereço de um pedido **através** do usuário. Para isso, vamos criar o método `address` no Model `Order`:

```php
// App\Models\Order.php
// Um pedido tem um endereço através de um usuário
public function address(): HasOneThrough
{
    return $this->hasOneThrough
    (
        // O primeiro argumento é a Model que queremos acessar
        Address::class,
        // Model intermediária
        User::class,
        // Chave estrangeira da Model intermediária
        'id',
        // Chave estrangeira da Model que queremos acessar
        'user_id',
    );
}
```

Ou seja, um pedido tem um endereço **através** de um usuário. Então ao invés de acessar o endereço através do usuário, podemos acessar diretamente pelo pedido.

---

## HasManyThrough

O `HasManyThrough` (TemMuitosAtravés) é semelhante ao `HasOneThrough`, mas ao invés de retornar um único registro, ele retorna uma `Collection` de registros. Neste exemplo vamos utilizar de um exemplo de `College`, que tem muitos `Teacher` e cada `Teacher` tem muitas `Lesson`.

Primeiro, vamos criar os relacionamentos básicos entre as Models `College`, `Teacher` e `Lesson`:

```php
// App\Models\College.php
// Uma escola tem muitos professores
public function teachers(): HasMany
{
    return $this->hasMany(Teacher::class);
}

// App\Models\Teacher.php
// Um professor pertence a uma escola e tem muitas aulas
public function college(): BelongsTo
{
    return $this->belongsTo(College::class);
}

public function lessons(): HasMany
{
    return $this->hasMany(Lesson::class);
}

// App\Models\Lesson.php
// Uma aula pertence a um professor
public function teacher(): BelongsTo
{
    return $this->belongsTo(Teacher::class);
}
```

Agora, vamos acessar as aulas de uma escola através dos professores. Para isso, vamos criar o método `lessons` no Model `College`:

```php
// App\Models\College.php
public function lessons(): HasManyThrough
{
    return $this->hasManyThrough
    (
        Lesson::class,
        Teacher::class,
        'id',
        'teacher_id',
    );
}
```

Ou seja, uma escola tem muitas aulas **através** de um professor. Ao invés de acessar as aulas através do professor, podemos acessar diretamente pela Model `College`.

---

## Referências e Recursos

Fiz esse repositório baseado em duas principais fontes para entender e estruturar melhor os relacionamentos no Laravel.
- [Documentação oficial do Laravel](https://laravel.com/docs/)
- [Curso de Relacionamentos do Clube Full-Stack](https://www.youtube.com/watch?v=pL_th7hHRxE&list=PLyugqHiq-SKcCjcxq33TGy5i-E3O0lHdv&pp=iAQB)

Consulte essas fontes para um estudo mais aprofundado sobre cada tipo de relacionamento 🫡

## Contribuição

Contribuições são bem-vindas! Se você encontrou um erro, tem sugestões de melhoria ou deseja adicionar um novo exemplo, fique à vontade para abrir uma `issue` ou um `pull request`.

### Para contribuir:
1. Faça um fork do projeto
2. Crie uma nova branch com sua contribuição (`git checkout -b feat/nome-da-feature`)
3. Commit suas alterações (`git commit -m 'Descrição da sua contribuição'`)
4. Faça o push para sua branch (`git push origin feature/nome-da-sua-feature`)
5. Abra um Pull Request para o repositório original

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE.md](LICENSE.md) para mais detalhes.
