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
   - [HasOneOfMany](#hasoneofmany)
   - [BelongsTo](#belongsto)
   - [BelongsToMany](#belongstomany)
   - [HasOneThrough](#hasonethrough)
   - [HasManyThrough](#hasmanythrough)
   - [Polimorfismo](#polimorfismo)
   - [MorphOne](#morphone)
   - [MorphMany](#morphmany)
   - [MorphTo](#morphto)
   - [MorphToMany](#morphtomany)

- [Referências e Recursos](#referências-e-recursos)
- [Contribuição](#contribuição)

## Informações Gerais

1. Convenções de nomenclatura
   - No Laravel assumimos que a chave estrangeira (FK) terá o nome do Model em `snake_case` seguido de `_id`. Por exemplo, se temos um Model `User`, a chave estrangeira será `user_id`.
   - O Laravel também assume que a chave primária (PK) será `id`. Se você deseja usar outro nome para a chave primária, você deve especificar isso no Model.
   - Em relacionamento polimórficos o Laravel tem por convenção que o nome do método seja o nome da relação seguido de `able`. Por exemplo, se temos um relacionamento polimórfico entre `Comment` e `Post`, o método será `commentable`.

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

## HasOneOfMany

O relacionamento `HasOneOfMany` (TemUmDeMuitos) é usado quando uma Model possui exatamente uma instância de outra Model, mas essa Model pode estar associada a várias instâncias da Model pai. A diferença entre `HasOne` e `HasOneOfMany` é que, no `HasOneOfMany`, a instância única é determinada por uma condição ou critério, como o registro mais recente, mais antigo ou com base em outra característica.

### Exemplo

Imagine que um usuário pode ter vários endereços, mas queremos identificar o endereço principal com base no campo `is_main`:

```php
// App\Models\User.php
use Illuminate\Database\Eloquent\Relations\HasOneOfMany;

public function mainAddress(): HasOneOfMany
{
    return $this->hasOneOfMany(Address::class, 'user_id')->where('is_main', true);
}

// App\Models\Address.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Nesse exemplo, o método mainAddress retorna apenas o endereço principal do usuário, baseado na condição `is_main = true`.

Use `HasOneOfMany` sempre que precisar trabalhar com relações que exijam critérios específicos para determinar a instância única do relacionamento.

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
    return $this->belongsToMany(
        // Model que queremos relacionar
        Course::class, 
        // Nome da tabela intermediária
        'student_courses'
    );
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

### Laravel e a DX (Developer Experience)
O Laravel é conhecido por sua DX (Developer Experience) e por simplificar tarefas complexas. Uma dessas facilidades que temos no processo de codar é a utilização de relacionamentos `HasOneThrough` e `HasManyThrough`. 

---

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
        // Chave primária da Model que queremos acessar
        'id',
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

## Polimorfismo

O polimorfismo é um conceito que permite que um objeto possa ser tratado de várias formas. No Laravel, o polimorfismo é usado para criar relações polimórficas entre Models.

Sendo mais didático, imagine que temos uma Model `Comment` que pode ser associada a uma Model `Post` ou a uma Model `Video`. Neste caso, podemos usar o polimorfismo para criar uma relação polimórfica entre `Comment` e `Post` e `Comment` e `Video`.

```php
// App\Models\Comment.php
public function commentable(): MorphTo
{
    return $this->morphTo();
}

// App\Models\Post.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}

// App\Models\Video.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}
```

Ou seja, um comentário pode ser associado a um post ou a um vídeo.

_ps: Esse sufixo `able` é uma convenção do Laravel para indicar que a Model é polimórfica. No exemplo dado, `commentable` é o método que define a relação polimórfica._ 

Isto posto, vamos falar agora sobre as relações polimórficas disponíveis no Laravel:

---

## MorphOne

O relacionamento `MorphOne` é usado quando uma Model possui exatamente uma instância de outra Model. Vamos dar o exemplo de uma uma `Image` em um Blog, que pode ser associada a um `Post` ou a uma `Category`.

```php
// App\Models\Image.php
public function imageable(): MorphTo
{
    return $this->morphTo();
}

// App\Models\Post.php
public function image(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable');
}

// App\Models\Category.php
public function image(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable');
}
```

Desta forma, definimos que uma imagem pode ser associada a um post ou a uma categoria.

---

## MorphMany

O `MorphMany` é usado quando uma Model pode ter múltiplas instâncias de outra Model. Por exemplo um `Comment` que pode ser associada a um `Post` ou a uma `Video`.

```php
// App\Models\Comment.php
public function commentable(): MorphTo
{
    return $this->morphTo();
}

// App\Models\Post.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}

// App\Models\Video.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}
```

Desta forma, definimos que um comentário pode ser associado a um `Post` ou a um `Video`.

---

## MorphTo

O relacionamento `MorphTo` é usado quando uma Model pode pertencer a uma de várias Models. Vamos dar o exemplo de uma `Image` que pode pertencer a um `Post` ou a uma `Category`.

```php
// App\Models\Image.php
public function imageable(): MorphTo
{
    return $this->morphTo();
}

// App\Models\Post.php
public function image(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable');
}

// App\Models\Category.php
public function image(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable');
}
```

Desta forma, definimos que uma imagem pode pertencer a um post ou a uma categoria.

---

## MorphToMany

O relacionamento `MorphToMany` é usado quando uma Model pode ter múltiplas instâncias de outra Model e vice-versa. Vamos usar o exemplo clássico de `Tag` que pode ser associada a um `Post` ou a uma `Video`.

```php
// App\Models\Tag.php
public function posts(): MorphToMany
{
    return $this->morphedByMany(Post::class, 'taggable');
}

public function videos(): MorphToMany
{
    return $this->morphedByMany(Video::class, 'taggable');
}

// App\Models\Post.php
public function tags(): MorphToMany
{
    return $this->morphToMany(Tag::class, 'taggable');
}

// App\Models\Video.php
public function tags(): MorphToMany
{
    return $this->morphToMany(Tag::class, 'taggable');
}
```

Desta forma, definimos que uma tag pode ser associada a um post ou a um vídeo.

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
