<?php

namespace App\Http\Controllers;

use App\Shoppinglist;
use App\Item;
use App\Comment;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppinglistController extends Controller
{
    public function index(){
        $lists = Shoppinglist::with(['items', 'comments', 'seeker', 'volunteer'])->get();
        return $lists;
    }

    public function findByTitle(string $title):Shoppinglist{
        $list = Shoppinglist::where('title', $title)->with(['items', 'comments', 'seeker', 'volunteer'])->first();
        return $list;
    }

    public function getSingle(int $id):Shoppinglist{
        $list = Shoppinglist::where('id', $id)->with(['items', 'comments', 'seeker', 'volunteer'])->first();
        return $list;
    }

    public function getFreeLists(){
        $freeLists = Shoppinglist::where('volunteer_id', null)->get();
        return $freeLists;
    }

    public function getVolunteersLists(int $volunteerId){
        $vLists = Shoppinglist::where('volunteer_id', $volunteerId)->get();;
        return $vLists;
    }

    public function getUserById(int $id): User{
        $user = User::where('id', $id)->first();
        return $user;
    }

    public function show(Shoppinglist $list){
        return view('lists.show', compact('list'));
    }


    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    //
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function save(Request $request):JsonResponse{
        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try{
            $list = Shoppinglist::create($request->all());

            if(isset($request['items']) && is_array($request['items'])){
                foreach ($request['items'] as $itm){
                    $item = Item::firstOrNew(['title'=>$itm['title'], 'amount'=>$itm['amount'], 'unit'=>$itm['unit'], 'price'=>$itm['price']]);
                    $list->items()->save($item);
                }
            }

            if(isset($request['comments']) && is_array($request['comments'])){
                foreach ($request['comments'] as $cmt){
                    $comment = Comment::firstOrNew(['text'=>$cmt['text'], 'user_id'=>$cmt['user_id']]);
                    $list->comments()->save($comment);
                }
            }

            DB::commit();
            return response()->json($list, 201);
        }

        catch (\Exception $e){
            DB::rollBack();
            return response()->json("saving list failed: " .$e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request):Request{
        $date = new \DateTime($request->created_at);
        $request['created_at'] = $date;
        return $request;
    }
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    //
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function update(Request $request, int $id):JsonResponse{
        DB::beginTransaction();
        try{
            $list = Shoppinglist::with(['items', 'comments','seeker', 'volunteer'])->where('id', $id)->first();
            if($list != null){
                $request = $this->parseRequest($request);
                $list->update($request->all());

                $list->items()->delete();

                if(isset($request['items']) && is_array($request['items'])){
                    //$list->items()->delete();
                    foreach ($request['items'] as $itm){
                        $item = Item::firstOrNew(['title' => $itm['title'], 'amount'=>$itm['amount'], 'unit'=>$itm['unit'], 'price'=>$itm['price']]);
                        $list->items()->save($item);
                    }
                }

                $list->save();
            }
            DB::commit();
            $list1 = Shoppinglist::with(['items', 'comments','seeker', 'volunteer'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($list1, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json("updating list failed: " .$e->getMessage(), 420);
        }
    }

    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    //
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    public function updateComments(Request $request, int $id):JsonResponse{
        DB::beginTransaction();
        try{
            $list = Shoppinglist::with(['items', 'comments','seeker', 'volunteer'])->where('id', $id)->first();
            if($list != null) {
                $request = $this->parseRequest($request);
                $list->update($request->all());

                $list->comments()->delete();

                if (isset($request['comments']) && is_array($request['comments'])) {
                    //$list->comments()->delete();
                    foreach ($request['comments'] as $cmt) {
                        $comment = Comment::firstOrNew(['text' => $cmt['text'], 'user_id' => $cmt['user_id']]);
                        $list->comments()->save($comment);
                    }
                }
                $list->save();
            }
            DB::commit();
            $list1 = Shoppinglist::with(['items', 'comments','seeker', 'volunteer'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($list1, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json("updating Comments failed: " .$e->getMessage(), 420);
        }
    }
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    //
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    public function delete(int $id):JsonResponse{
        $list = Shoppinglist::where('id', $id)->first();
        $title = $list->title;
        if($list != null){
            $list->delete();
        }
        else
            throw new \Exception("list couldn't be deleted - it doesn't exist");
        return response()->json('list "' . $title . '" successfully deleted', 200);
    }

}
