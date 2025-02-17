<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\View\View;
use App\HPosition;
use App\Incumbent;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

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
            $id = 1;
        }
        $position = Position::find($id);


// set parameters for the current TEAM to session variables
        $user = Auth::user();
        Session::put('level1Desc', $user->currentTeam->Level1Desc);
        Session::put('level2Desc', $user->currentTeam->Level2Desc);
        Session::put('level3Desc', $user->currentTeam->Level3Desc);
        Session::put('level4Desc', $user->currentTeam->Level4Desc);
        Session::put('level5Desc', $user->currentTeam->Level5Desc);
        // dump($user->currentTeam->Level1Desc);

        // if sess var positionID is null, then this is a fresh launch.  Save the current ID to the session variable
        $sessionPositionID = Session::get('positionID');
        if (is_null($sessionPositionID)) {
            $sessionPositionID = $id;
            Session::put('positionID', $id);
        }

        // the next IFs check to see if a search parameter has been passed via request-inputs from NavBar.
        // if specific parameters have been passed then remember them.
        // if nothing has been passed, do nothing so that the session variables don't change and Navbar remembers the last search when you go back to the position.show.blade
        if (request()->has('company')) {
            if (empty(request()->input('company'))) {
                Session::put('posNavbarCompanyQuery', '');
            } else {
                Session::put('posNavbarCompanyQuery', request()->input('company'));
            }
        }

        if (request()->has('descr')) {
            if (empty(request()->input('descr'))) {
                Session::put('posNavbarDescrQuery', '');
            } else {
                Session::put('posNavbarDescrQuery', request()->input('descr'));
            }
        }

        if (request()->has('posno')) {
            if (empty(request()->input('posno'))) {
                Session::put('posNavbarPosnoQuery', '');
            } else {
                Session::put('posNavbarPosnoQuery', request()->input('posno'));
            }
        }

        if (request()->has('level1')) {
            if (empty(request()->input('level1'))) {
                Session::put('posNavbarLevel1Query', '');
            } else {
                Session::put('posNavbarLevel1Query', request()->input('level1'));
            }
        }

        if (request()->has('level2')) {
            if (empty(request()->input('level2'))) {
                Session::put('posNavbarLevel2Query', '');
            } else {
                Session::put('posNavbarLevel2Query', request()->input('level2'));
            }
        }

        if (request()->has('level3')) {
            if (empty(request()->input('level3'))) {
                Session::put('posNavbarLevel3Query', '');
            } else {
                Session::put('posNavbarLevel3Query', request()->input('level3'));
            }
        }

        if (request()->has('level4')) {
            if (empty(request()->input('level4'))) {
                Session::put('posNavbarLevel4Query', '');
            } else {
                Session::put('posNavbarLevel4Query', request()->input('level4'));
            }
        }

        if (request()->has('level5')) {
            if (empty(request()->input('level5'))) {
                Session::put('posNavbarLevel5Query', '');
            } else {
                Session::put('posNavbarLevel5Query', request()->input('level5'));
            }
        }

        // if (!empty(request()->input('posno'))) {
        //   Session::put('posNavbarPosnoQuery',request()->input('posno'));
        // }
        //
        // if (!empty(request()->input('descr'))) {
        //   Session::put('posNavbarDescrQuery',request()->input('descr'));
        // }
        //xxxxxxxxxxxxxxxxxxxxxxxx
        //xxxxxxxxxxxxxxxxxxxxxxxx


        //\/\/\/\/\/\/\/\/\/\/\
        // Restore all variables as they were on last SHOW. could be NULL if first time
        //\/\/\/\/\/\/\/\/\/\/\

        //\/\/\/\/\/\/\/\/\/\/\
        // if we just selected a new position, then clear out position specific session variables
        //\/\/\/\/\/\/\/\/\/\/\
        // reports to
        // incumbents, incumbent history
        // position history
        //
        //newly selected position
// dump("2:  ".getTimestamp());

        if ($sessionPositionID <> $id) { // not on the same position as last time
            // code...
// dump('on new position');
            Session::put('positionID', $id);
            $viewincid = '';
            // dump('New position!!');
            // dump($sessionPositionID);
            // dump($id);
            // clear out all session variables.  If applicable, reset to the current position
            Session::put('freshPosition', 'YES');
            $freshPosition = "YES";
            Session::put('reportsDirTo', '');
            Session::put('reportsIndirTo', '');
            Session::put('viewincid', '');
            Session::put('viewinchistid', '');
            $viewinchistid = '';
            Session::put('viewposhistid', '');
            // Session::put('editMode', '');
//            SessionSet("ExpandIncumbentHistory","N");

        } else {
// dump('Same Position');
            $freshPosition = "NO";
            Session::put('freshPosition', 'NO');
            $viewincid = Session::get('viewincid');
            $viewinchistid = Session::get('viewinchistid');
            $viewposhistid = Session::get('viewposhistid');
            $reportsDirTo = Session::get('reportsDirTo');
            $reportsIndirTo = Session::get('reportsIndirTo');
            // $editMode = Session::get('editMode');

        }
        //dump('checking whether session variable was set ... ' . $viewincid);

// dump("starting show...viewinhistcid = " );
// dump($viewinchistid);


        //gather general info
        $posno = $position->posno;
        $company = $position->company;

        // control whether in ReadOnly or Edit mode
        // switch is a toggle, so if you see SWITCH then detect current state and switch to other state
//        $switcheditmode = $request->input('editmode');
        $readOnlyText = Session::get('readOnlyText');
        // dump($freshPosition);
        // dump($switcheditmode);
        // dump($readOnlyText);
        if ($freshPosition == "YES") {
            // dump("freshxxx");
            // on new position
            // Do NOT want to be in edit mode...set readonly and disabled texts
            Session::put('readOnlyText', 'readonly');
            Session::put('disabledText', 'disabled');
            Session::put('editModeButtonText', 'Switch to Edit Mode');
        } else {
            // have not change positions
            // if null, no change...leave as is
            // if "switch" then detect current mode and switch to other mode
//            if ($switcheditmode=="switch"){
//                if ($readOnlyText<>"readonly"){
//                    // dump("1");
//                    // currently in edit mode, switch to NOT in edit mode...set readonly and disabled texts
//                    Session::put('readOnlyText', 'readonly');
//                    Session::put('disabledText', 'disabled');
//                    Session::put('editModeButtonText', 'Switch to Edit Mode');
//                }else{
//                    // dump("2");
//                    // in edit mode...leave readonly and disabled texts as blank
//                    Session::put('readOnlyText', '');
//                    Session::put('disabledText', '');
//                    Session::put('editModeButtonText', 'Leave Edit Mode');
//                }
//            }
        }
        // dump($switcheditmode);

// dump("3:  ".getTimestamp());
        //****************************
        // N A V B A R
        // these variables are used to populate the NavBar, not the main portion of Positions.Show
        // $navbarcompany = $request->input('company');
        // $navbarposno = $request->input('posno');
        // $navbardescr = $request->input('descr');
        // $navbarcompany = $request->input('company');
        // $navbarposno = $request->input('posno');
        // $navbardescr = $request->input('descr');
        $navbarcompany = Session::get('posNavbarCompanyQuery');
        $navbarposno = Session::get('posNavbarPosnoQuery');
        $navbardescr = Session::get('posNavbarDescrQuery');
        $navbarlevel1 = Session::get('posNavbarLevel1Query');
        $navbarlevel2 = Session::get('posNavbarLevel2Query');
        $navbarlevel3 = Session::get('posNavbarLevel3Query');
        $navbarlevel4 = Session::get('posNavbarLevel4Query');
        $navbarlevel5 = Session::get('posNavbarLevel5Query');


        // dump($request);
        // dump($navbarcompany);

//        $testAriaCollapse = $request->input('testArial');
//dump($testAriaCollapse);
//dump($navbarposno);

        $positionsnavbar = position::where('company', 'like', "$navbarcompany%")
            ->where('posno', 'like', "$navbarposno%")
            ->where('descr', 'like', "%$navbardescr%")
            ->where('level1', 'like', "$navbarlevel1%")
            ->where('level2', 'like', "$navbarlevel2%")
            ->where('level3', 'like', "$navbarlevel3%")
            ->where('level4', 'like', "$navbarlevel4%")
            ->where('level5', 'like', "$navbarlevel5%")
            ->orderby("company")
            ->orderby("descr")
            ->get();

//dd($positionsnavbar);


        return view('positions.show')
            ->with("id", $id)
            ->with(compact('position'))
            ->with(compact('positionsnavbar'));


    }
}
