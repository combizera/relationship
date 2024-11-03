# Relacionamentos no Laravel

Os relacionamentos no Laravel são excelentes para gerenciar e trabalhar com relacionamentos entre diferentes tabelas do Banco de Dados.

Nesse projeto estou me baseando pela [documentação](https://laravel.com/docs/) oficial do Laravel e também pelo curso de Relacionamento do [Clube Full-Stack](https://www.youtube.com/watch?v=pL_th7hHRxE&list=PLyugqHiq-SKcCjcxq33TGy5i-E3O0lHdv&pp=iAQB).

## Informações Gerais

1. Convenções de nomenclatura
   - No Laravel assumimos que a chave estrangeira (FK) terá o nome do Model em `snake_case` seguido de `_id`. Por exemplo, se temos um Model `User`, a chave estrangeira será `user_id`.

---

## HasOne

O relacionamento `HasOne` é usado quando um Model possui exatamente uma instância de outro Model. Por exemplo, um usuário pode ter um avatar.
    
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
O relacionamento `HasMany` é usado quando um Model pode ter múltiplas instâncias de outro Model. Por exemplo, um usuário pode ter vários posts.

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

Ou seja, um usuário pode ter *muitos* posts e um post pertence a um usuário.

---

## BelongsTo

O relacionamento `BelongsTo` é o inverso de `HasOne` ou `HasMany`. É usado quando um Model pertence a outro Model. Por exemplo, um post pertence a um usuário.

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

Ou seja, um comentário pertence a um post e um post pode ter *muitos* comentários.

---

## BelongsToMany

O relacionamento `BelongsToMany` é usado quando uma Model pode ter múltiplas instâncias de outra Model e vice-versa. 

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
Ou, um estudante pode ter estar matriculado em vários cursos e um curso é capaz de ter vários estudantes matriculados.

---

## HasOneThrough

### Through - Através
Primeiro, pra ajudar a entender, vamos traduzir a palavra `Through` para o português. `Through` significa `Através`. Então, `HasOneThrough` seria algo como `TemUmAtravés`.

Usamos o `HasOneThrough` quando queremos acessar um registro que está indiretamente relacionado através de uma `Model` intermediária. Ele é útil quando um Model está a uma "distância" de outra tabela, e queremos simplificar o acesso.

Primeiro fazemos o relacionamento básico entre as Models `User`, `Address` e `Order`:
```php
// App\Models\User.php
public function orders(): HasMany
{
    return $this->hasMany(Order::class);
}

public function address(): HasOne
{
    return $this->hasOne(Address::class);
}

// App\Models\Order.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

// App\Models\Address.php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Agora, vamos acessar o endereço de um pedido através do usuário. Para isso, vamos criar o método `address` no Model `Order`:

```php
// App\Models\Order.php

public function address(): HasOneThrough
{
    return $this->hasOneThrough
    (
        Address::class,
        User::class,
        'id',
        'user_id',
    );
}
```

Ou seja, um pedido tem um endereço **através** de um usuário. Então ao invés de acessar o endereço através do usuário, podemos acessar diretamente pelo pedido.

---

## HasManyThrough

O `HasManyThrough` é semelhante ao `HasOneThrough`, mas ao invés de retornar um único registro, ele retorna uma coleção de registros. Neste exemplo vamos utilizar de um exemplo de `College`, que tem muitos `Teacher` e cada `Teacher` tem muitas `Lesson`.

Primeiro, vamos criar os relacionamentos básicos entre as Models `College`, `Teacher` e `Lesson`:

```php
// App\Models\College.php
public function teachers(): HasMany
{
    return $this->hasMany(Teacher::class);
}

// App\Models\Teacher.php
public function college(): BelongsTo
{
    return $this->belongsTo(College::class);
}

public function lessons(): HasMany
{
    return $this->hasMany(Lesson::class);
}

// App\Models\Lesson.php
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

