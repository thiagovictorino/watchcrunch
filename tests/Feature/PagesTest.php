<?php

it('has about page')
    ->get('/about')
    ->assertSee('This is the about page');

it('has contact page')
    ->get('/contact')
    ->assertSee('This is the contact page');

it('has welcome page')
    ->get('/')
    ->assertSee('This is the welcome page');
