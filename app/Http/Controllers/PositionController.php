<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * Show the profile for a given position
     */
    public function shownoid()
    {


        return view('404');

    }

    public function show($id)
    {
      if (is_null($id)) {
        $id=1;
      }

        $id;
        $test=99;
        $test2="abcd";
        $test3="now is the time for all good men to come to the aid of their country";
        dump("Controller ID:..not a real id.".$test);
      dump("Controller ID...this is the real id:  " . $id);
      dump($test);
      dump($test2);
      dump($test3);

        return view('positions')
            ->with("id", $id)
            ->with("test", $test)
            ->with("test2", $test2)
            ->with("test3", $test3);
    }
}
