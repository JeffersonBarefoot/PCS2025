<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\View\View;

class PositionController extends Controller
{
    //***************************************************
    //***************************************************
    //***************************************************
    //**   S H O W   ( N 0   I D )
    //***************************************************
    //***************************************************
    //***************************************************
    public function shownoid()
    {


        return view('positions.404');

    }

    //***************************************************
    //***************************************************
    //***************************************************
    //**   S H O W
    //***************************************************
    //***************************************************
    //***************************************************
    public function show($id)
    {

        if (is_null($id)) {
            $id=1;
        }
        $position = Position::find($id);




        $id;
        $test=99;
        $test2="abcd";
        $test3="now is the time for all good men to come to the aid of their country";
//Test Dumps...all of these worked on 20250216
//        dump($position);
//        dump("Controller ID:..not a real id.".$test);
//      dump("Controller ID...this is the real id:  " . $id);
//      dump($test);
//      dump($test2);
//      dump($test3);

        return view('positions.show')
            ->with("id", $id)
            ->with(compact('position'))
            ->with("test", $test)
            ->with("test2", $test2)
            ->with("test3", $test3);
    }
}
