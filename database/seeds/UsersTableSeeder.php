<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User;
        $user->email = 'testV@gmail.com';
        $user->volunteer = true;
        $user->firstname = 'Franziska';
        $user->lastname = 'Rußmann';
        $user->address = 'Schaufelhackerstraße 5, 4591 Molln';
        //speichert passwort verschlüsselt in DB
        $user->password = bcrypt('secret');
        $user->save();

        $user1 = new App\User;
        $user1->email = 'testS@gmail.com';
        $user1->volunteer = false;
        $user1->firstname = 'Waltraud';
        $user1->lastname = 'Steiner';
        $user1->address = 'Kapellenstraße 5, 4591 Molln';
        //speichert passwort verschlüsselt in DB
        $user1->password = bcrypt('secret');
        $user1->save();

        $user2 = new App\User;
        $user2->email = 'test2@gmail.com';
        $user2->volunteer = false;
        $user2->firstname = 'Margareth';
        $user2->lastname = 'Hasenleitner';
        $user2->address = 'Austraße 10, 4591 Molln';
        //speichert passwort verschlüsselt in DB
        $user2->password = bcrypt('secret');
        $user2->save();
    }
}
