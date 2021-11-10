<?php

use Illuminate\Support\Str;
use function Pest\Faker\faker;

dataset('users_make', [
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
    [Str::replace('.', '-', faker()->userName), faker()->unique->safeEmail],
]);

dataset('forbidden_usernames', [
    ['about', faker()->unique->safeEmail],
    ['contact', faker()->unique->safeEmail],
]);
