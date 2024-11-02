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

O relacionamento `BelongsToMany` é usado quando uma Model pode ter múltiplas instâncias de outra Model e vice-versa. Por exemplo, um estudante pode ter estar matriculado em vários cursos e um curso é capaz de ter vários estudantes matriculados.

```php
// App\Models\Student.php
public function courses(): BelongsToMany
{
    return $this->belongsToMany(Course::class, 'student_courses');
}

// App\Models\Course.php
public function students(): BelongsToMany
{
    return $this->belongsToMany(Student::class, 'student_courses');
}
```

---

## HasOneThrough

---

## HasManyThrough

---

