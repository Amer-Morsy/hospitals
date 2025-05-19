<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('create-invoice.{doctor_id}', function ($user, $doctor_id) {
    return $user->id == $doctor_id;
},
    ['guards' => ['web','admin','patient','doctor','ray_employee','laboratorie_employee', 'api']]
);
