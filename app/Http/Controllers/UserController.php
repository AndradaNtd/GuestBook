<?php

namespace App\Http\Controllers;

use App\Replay;
use App\Review;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    public function registerUser(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:'.$this->getAssignedModel()->getTable().',email',
            'password' => 'required'
        ]);
        $input = $request->input();
        $input['password'] = bcrypt($input['password']);
        $newUser = User::create($input);
        return $this->respondCreated($newUser->toArray());
    }
    public function login (Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $auth = auth()->guard('web');

        $credentials = [
            'email' =>  $request->input('email'),
            'password' =>  $request->input('password')
        ];
        if ($auth->attempt($credentials) ) {
            $data = $auth->user()->toArray();
            $apiToken = str_random(60);
            $user = User::find($data['id']);
            $user->api_token = $apiToken;
            $user->save();
            return $this->respondOk($user->toArray());
        } else {
            return $this->respondUnauthorized($this->buildGeneralErrorResponse('Invalid username or password'));
        }
    }

    public function showAllReview (){
        $reviewModel = Review::orderBy('created_at', 'desc')
            ->with('replays')->get();
        return $this->respondOk($reviewModel->toArray());
    }

    public function storeReview(Request $request){
        $this->validate($request, [
            'review' => 'required',
        ]);
        $input = $request->input();
        $input['user_id'] = Auth::guard('api')->user()->id;
        $newReview = Review::create($input);
        return $this->respondCreated($newReview->toArray());
    }

    public function storeReplay(Request $request){
        $this->validate($request, [
            'replay' => 'required',
            'review_id' => 'required|numeric|exists:' . $this->getReviewModel()->getTable() . ',id',
        ]);
        $input = $request->input();
        $newReplay = Replay::create($input);
        return $this->respondCreated($newReplay->toArray());
    }
    public function getAssignedModel(){
        return app('App\User');
    }

    public function getReviewModel() {
        return app('App\Review');
    }


}
