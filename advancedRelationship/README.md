# Relacionamentos Avançados

Aqui vamos dar um passo adiante, mostrarei como trabalhar com relacionamentos avançados no Laravel e outras consultas relacionadas.

## Índice
- [Trabalhando com `whereHas`](#trabalhando-com-wherehas)

## Trabalhando com `whereHas`

O método `whereHas` é útil para recuperar registros que possuem condições específicas aplicadas aos seus relacionamentos. Por exemplo, podemos buscar apenas os posts que possuem pelo menos um comentário aprovado.

## Exemplo sem `whereHas`

Sem usar `whereHas`, você precisaria recuperar todos os posts e filtrar manualmente os que possuem comentários aprovados:

```php
// Recuperando todos os posts e filtrando manualmente
$posts = Post::with('comments')->get();
$filteredPosts = $posts->filter(function ($post) {
    return $post->comments->where('approved', true)->count() > 0;
});
```
Essa abordagem pode ser ineficiente, pois carrega todos os posts e comentários na memória.

### Exemplo com `whereHas`
Usando `whereHas`, a filtragem é feita diretamente no banco de dados, tornando a consulta mais eficiente:

```php
// Recuperando apenas os posts que possuem comentários aprovados
$posts = Post::whereHas('comments', function ($query) {
    $query->where('approved', true);
})->get();
```

### Combinação com `orWhereHas`
Você também pode combinar condições relacionadas usando `orWhereHas`. Por exemplo, buscar posts com pelo menos um comentário aprovado ou destacado:
    
```php
$posts = Post::whereHas('comments', function ($query) {
$query->where('approved', true);
})->orWhereHas('comments', function ($query) {
$query->where('highlighted', true);
})->get();
```

### Benefícios do `whereHas`

- **Eficiência:** Filtragem direta no banco de dados, sem carregar dados desnecessários. 
- **Clareza:** Código mais simples e expressivo.
- **Escalabilidade:** Ideal para grandes volumes de dados.
  
---
