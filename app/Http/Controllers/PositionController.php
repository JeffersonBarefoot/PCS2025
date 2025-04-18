<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\View\View;
use App\Models\HPosition;
use App\Models\Incumbent;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class PositionController extends Controller
{

//    Receives parameter like "P201ShowT"
//    ...then sets Session Variable P201Show to "true" (or false)
    public function updateCollapseStatus(Request $request)
    {

        $status = $request->input('status');
        $sessionVar = substr($status, 0, 8);
        $showStatus = substr($status,-1);
        dump($showStatus);

        if ($showStatus=="T") {
            $showStatus = true;
        } else {
            $showStatus = false;
        }

        Session::put($sessionVar, $showStatus);
        return response()->json(['status' => 'success']);
    }

    //***************************************************
    //***************************************************
    //***************************************************
    //**   C R E A T E
    //**   This works together with STORE to add a new record
    //***************************************************
    //***************************************************
    //***************************************************
    public function create()
    {
        return view('positions.create');
    }

    //***************************************************
    //***************************************************
    //***************************************************
    //**   S T O R E
    //**   This works together with CREATE to add a new record
    //***************************************************
    //***************************************************
    //***************************************************
    public function store(Request $request)
    {
        dump('positioncontroller.store');

        $request->validate([
            'company'=>'required',
            'posno'=>'required',
            'descr'=>'required'
        ]);

        $position = new Position([
            'company' => $request->get('company'),
            'posno' => $request->get('posno'),
            'descr' => $request->get('descr')
        ]);
        $position->save();
        return redirect('/positions/1')->with('success', 'Position saved!');
    }

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
    public function show($id, Request $request)
    {
//dd($request);
//Flashes the current input to the session so it's available during the user's next request to the application:
//       if (is_null($JEFFTEST)) {
//           $JEFFTEST = "NEW FROM CONTROLLER";
//       }
//        dump('Show in PositionController');
        $request->flash();
//dd($request);

        if (is_null($id)) {
            $id = 1;
        }

//        findOrFail either creates the $position object, or fails and routes to 404
        $position = Position::findOrFail($id);




// set parameters for the current TEAM to session variables...
        $user = Auth::user();
        Session::put('level1Desc', $user->currentTeam->Level1Desc);
        Session::put('level2Desc', $user->currentTeam->Level2Desc);
        Session::put('level3Desc', $user->currentTeam->Level3Desc);
        Session::put('level4Desc', $user->currentTeam->Level4Desc);
        Session::put('level5Desc', $user->currentTeam->Level5Desc);

// See if the Session Vars for collapsing panels already exist.  If not, this is the first time running in this session, so initialize them
        if (!Session::has("P201Show")) {
            // if one doesn't exist then none exist.  Create and set them all to collapse
//            dump('PSec201Show doesnt exist in session');
            Session::put('P201Show', false);
            Session::put('P202Show', false);
            Session::put('P203Show', false);
            Session::put('P204Show', false);
            Session::put('P205Show', false);
            Session::put('P206Show', false);
            Session::put('P207Show', false);
            Session::put('P208Show', false);
            Session::put('P209Show', false);
            Session::put('P210Show', false);
            Session::put('P211Show', false);
            Session::put('P900Show', false);
            Session::put('R201Show', false);
        }
//        dump(Session::get("P201Show"));

//try to understand auth and logins, April 2025
//        dump($user);

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

// dump("starting show...viewinhistcid =  " );
// dump($viewinchistid);


        //gather general info
        $posno = $position->posno;
        $company = $position->company;

        // control whether in ReadOnly or Edit mode
        // switch is a toggle, so if you see SWITCH then detect current state and switch to other state
        $switcheditmode = $request->input('editmode');
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
            if ($switcheditmode=="switch"){
                if ($readOnlyText<>"readonly"){
//                    // dump("1");
//                    // currently in edit mode, switch to NOT in edit mode...set readonly and disabled texts
                    Session::put('readOnlyText', 'readonly');
                    Session::put('disabledText', 'disabled');
                    Session::put('editModeButtonText', 'Switch to Edit Mode');
                }else{
//                    // dump("2");
//                    // in edit mode...leave readonly and disabled texts as blank
                    Session::put('readOnlyText', '');
                    Session::put('disabledText', '');
                    Session::put('editModeButtonText', 'Leave Edit Mode');
                }
            }
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

        //****************************
        // I N C U M B E N T S
        // gather all incumbents related to this position

        if (!empty($request->input('viewinchistid'))) {
            $viewinchistid = $request->input('viewinchistid');

            //what if this is a new incHistId?  Do we blank out the details, or return first record?
            //jlb 20200225
            SessionSet("ExpandIncumbentHistory","Y");
        }
        // see if we passed a new viewincid, so need to update the variable
        // otherwise keep the one that we have been using
        if (!empty($request->input('viewincid'))) {
            $viewincid = $request->input('viewincid');
            $viewinchistid = '';
            SessionSet("ExpandIncumbentHistory","Y");
        }

        $incumbentCompany           = GetIncumbentFieldById($viewincid,'company');
        $incumbentEmpno             = GetIncumbentFieldById($viewincid,'empno');
        $incumbentsinposition       = GetIncumbents($company,$posno);
        $activeincumbentsinposition = GetActiveIncumbents($company,$posno);
        $viewincumbent              = GetIncumbentById($viewincid);
        $viewIncumbentHistory       = GetHIncumbent($incumbentCompany,$incumbentEmpno,$company,$posno);
        $activeincumbentcount       = $activeincumbentsinposition->count();

        // determine whether viewing a CURRENT or HISTORY record
        // this depends on which record in the middle DIV the user clicked on
        if (substr($viewinchistid,0,7)=="CURRENT") {
            // current record.  Strip out CURRENT designator and get record from Incumbents
            $idlength                 = strlen($viewinchistid);
            $viewinchistid            = substr($viewinchistid,7,$idlength-7);
            $viewIncumbentDetails     = GetIncumbentById($viewinchistid);
        } else {
            // history record.  Get record from HIncumbents
            $viewIncumbentDetails     = GetHIncumbentRecordById($viewinchistid);
        }

        // build a text element that can be displayed on the incumbents tab
        $activeincumbentlist = '';
        foreach ($activeincumbentsinposition as $ActInc){
            $activeincumbentlist = $activeincumbentlist.substr($ActInc->fname,0,1).' '.$ActInc->lname.', ' ;
        }

//****************************
        // P O S I T I O N   H I S T O R Y
        $posHistRecs = \DB::table('hpositions')
            ->where('posno','=',$posno)
            ->where('company','=',$company)
            ->orderby('historyend','desc')
            ->get();
        $positionhistorycount = $posHistRecs->count();

        // see if we need to show a specific position history record
        if (!empty($request->input('viewposhistid'))) {

            $viewposhistid = $request->input('viewposhistid');

            $viewPositionHistoryDetails = \DB::table('hpositions')
                ->where('id','=',$viewposhistid)
                ->get();

            SessionSet("ExpandPositionHistory","Y");

            //what if this is a new incHistId?  Do we blank out the details, or return first record?
            //jlb 20200225

        } else {

            // if a position history record id is not available, still need a blank table to avoid errors
            $viewPositionHistoryDetails = \DB::table('hpositions')
                ->where('id','=','blanktable')
                ->get();

            SessionSet("ExpandPositionHistory","N");

        }

// dump($viewPositionHistoryDetails);

// dump("6:  ".getTimestamp());

        //****************************
        // REPORTS TO data
        // "reports to" position is directly available in the positions table

        // check to see if reportsdirto was included in the request string.  If so, reset the Reports To Fields
        if (!empty($request->input('reportsdirto'))) {
            //dump('requested a new reports to');
            $reportsdirtoid = $request->input('reportsdirto');

            $reportsdirtocursor = \DB::table('positions')
                ->where('id','=',$reportsdirtoid)
                ->get();

            foreach ($reportsdirtocursor as $rdt){
                $rdtcompany=$rdt->company;
                $rdtposno=$rdt->posno;
                $rdtdescr=$rdt->descr;

                $position->reptocomp=$rdtcompany;
                $position->reptoposno=$rdtposno;
                $position->reptodesc=$rdtdescr;
                $position->save();
            }
        }

        // check to see if reportsdirto was included in the request string.  If so, reset the Reports To Fields
        if (!empty($request->input('reportsindirto'))) {
            //dump('requested a new reports to');
            $reportsindirtoid = $request->input('reportsindirto');

            $reportsindirtocursor = \DB::table('positions')
                ->where('id','=',$reportsindirtoid)
                ->get();

            foreach ($reportsindirtocursor as $rit){
                $ritcompany=$rit->company;
                $ritposno=$rit->posno;
                $ritdescr=$rit->descr;

                $position->reptocom2=$ritcompany;
                $position->reptopos2=$ritposno;
                $position->reptodesc2=$ritdescr;
                $position->save();
            }
        }


        // Direct Reports will reference this position in their positions.reptocomp / reptoposno
        // Dotted lines will have this position number in reptocom2 / reptopos2
        $directReports = \DB::table('positions')
            ->where('reptoposno','=',$posno)
            ->where('reptocomp','=',$company)
            ->orderby("descr")
            ->get();

        $indirectReports = \DB::table('positions')
            ->where('reptopos2','=',$posno)
            ->where('reptocom2','=',$company)
            ->orderby("descr")
            ->get();

        $dirRepCount = count($directReports);
        $indirRepCount = count($indirectReports);

        // get a collection of position names to use as a list to select "reports to" positions
        // will only need this in "editable" queries
        $reportsToSource = \DB::table('positions')
            ->select('id','company','posno','descr')
            ->where('company','=',$company)
            ->orderby("descr")
            ->get();



//dump($dirRepCount);
// dump("$posno");
// dump("$company");
// dump($directReports);
// dump($viewincumbent);
// $user = Auth::user();
// $id = Auth::id();
// dump($id);
// dump($user->currentTeam->name);
// dump($user->currentTeam->id);

//experiment with session variables, 2020-01-01
        Session::put('mykey', '12345');
        Session::put('expandIncumbents', 'xxHere is how you return a session variable into a blade...JLB 200113');
//TestOnclickFunction();

//######################
// IMPORT Data
// execute these lines to import sample data
//######################
// importpositions('');
// importhpositions('');
// importincumbents('');
// importhincumbents('');
// SeedPositionHistory(2,10);

//######################
//######################
//######################
//######################
//######################
// test functionality to export to Csv
// Seems to have worked.  Saves file to C:\Users\Jeffe\Homestead\Projects\spark-installer\PowerPCS-Spark\public
// $positions = position::get()->toArray();
// // dd($positions);
// //  UPDATE:  now saves to C:\Users\Jeffe\Homestead\Projects\spark-installer\PowerPCS-Spark\FileExports\TEAM00001
// $fp = fopen('../FileExports/TEAM00001/xxxfile.' . getTimestamp() .  '.csv', 'w');
// // $fp = fopen('xxxfile.csv', 'w');
// foreach ($positions as $pos) {
//   // dd($pos);
//     fputcsv($fp, $pos);
// }
// fclose($fp);
//######################
//######################
//######################
//######################
//######################
// dump($viewIncumbentHistory);
        // save all session variables prior to returning to the blade
        Session::put('reportsDirTo', '');
        Session::put('reportsIndirTo', '');
        Session::put('viewincid', $viewincid);
        Session::put('viewinchistid', $viewinchistid);
        Session::put('viewPosHistId', '');

//        dump("7:  ".getTimestamp());


//        return view('positions.show')
//            ->with("id", $id)
//            ->with(compact('position'))
//            ->with(compact('positionsnavbar'));



//dump(Session::get("P201Show"));
        //****************************
        // R E T U R N   T O   positions.show
        return View('positions.show')
            ->with(compact('position'))
            ->with(compact('viewincumbent'))
            ->with(compact('viewIncumbentHistory'))
            ->with(compact('viewIncumbentDetails'))
            ->with(compact('posHistRecs'))
            ->with(compact('viewPositionHistoryDetails'))
            ->with(compact('positionsnavbar'))
            ->with(compact('incumbentsinposition'))
            ->with(compact('directReports'))
            ->with(compact('indirectReports'))
            ->with(compact('reportsToSource'))
            ->with("id", $id)
//            ->with("JEFFTEST",$JEFFTEST)
            ->with('dirRepCount',$dirRepCount)
            ->with('indirRepCount',$indirRepCount)
            ->with('activeincumbentcount',$activeincumbentcount)
            ->with('activeincumbentlist',$activeincumbentlist)
            ->with('positionhistorycount',$positionhistorycount);


    }
}
