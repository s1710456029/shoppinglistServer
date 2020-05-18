<?php

use Illuminate\Database\Seeder;

class ShoppinglistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$seeker = \App\User::where('volunteer' == false)->first();
        //$volunteer = \App\User::where('volunteer' == true)->first();
        $seeker = new \App\User;
        $volunteer = new \App\User;
        $users = \App\User::all();
        foreach ($users as $user){
            if($user->volunteer == true){
                $volunteer = $user;
            }
            else
                $seeker = $user;
        }

        $slist = new \App\Shoppinglist;
        $slist->title = "Liste Sachertorte";
        $slist->due_date = date("2020-05-05");
        $slist->seeker()->associate($seeker);

        $slist->save();


        $item1 = new \App\Item;
        $item1->title = "Kochschoko Manner";
        $item1->amount = 2;
        $item1->unit = "Stück";
        $item1->price = 5;

        $item2 = new \App\Item;
        $item2->title = "Bio Freilandeier";
        $item2->amount = 10;
        $item2->unit = "Stück";
        $item2->price = 4;

        $item3 = new \App\Item;
        $item3->title = "Milch";
        $item3->amount = 2;
        $item3->unit = "Liter";
        $item3->price = 1.50;

        $slist->items()->saveMany([$item1, $item2, $item3]);



        $list1 = new \App\Shoppinglist;
        $list1->title = "Snaccident";
        $list1->due_date = date("2020-04-20");
        $list1->final_sum = 14.25;
        $list1->seeker()->associate($seeker);
        $list1->volunteer()->associate($volunteer);
        $list1->save();

        $item4 = new \App\Item;
        $item4->title = "Milka Schoko";
        $item4->amount = 10;
        $item4->unit = "Stück";
        $item4->price = 20;

        $item5 = new \App\Item;
        $item5->title = "Bananen";
        $item5->amount = 6;
        $item5->unit = "Stück";
        $item5->price = 5;


        $list1->items()->saveMany([$item4, $item5]);

    }
}
