<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public function uploadfile(Request $request)
    {
        $user   = auth()->user();
        $teamId = $user->currentTeam->id;

        $lines  = [];
        $errors = [];
        $noop   = true;

        if ($request->hasFile('importFileName1')) {
            $noop = false;
            $file = 'setupPosi_Team=' . $teamId . '_' . getTimestamp() . '.csv';
            $request->file('importFileName1')->storeAs($file);
            $r = ImportPositions($file, $teamId);
            $r['ok'] ? $lines[]  = "Positions: {$r['inserted']} imported, {$r['skipped']} skipped."
                     : $errors[] = "Positions: {$r['error']}";
        }

        if ($request->hasFile('importFileName2')) {
            $noop = false;
            $file = 'setupPosH_Team=' . $teamId . '_' . getTimestamp() . '.csv';
            $request->file('importFileName2')->storeAs($file);
            $r = ImportHPositions($file);
            $r['ok'] ? $lines[]  = "Position history: {$r['inserted']} imported."
                     : $errors[] = "Position history: {$r['error']}";
        }

        if ($request->hasFile('importFileName3')) {
            $noop = false;
            $file = 'setupIncu_Team=' . $teamId . '_' . getTimestamp() . '.csv';
            $request->file('importFileName3')->storeAs($file);
            $r = ImportIncumbents($file, $teamId);
            $r['ok'] ? $lines[]  = "Incumbents: {$r['inserted']} imported, {$r['skipped']} skipped."
                     : $errors[] = "Incumbents: {$r['error']}";
        }

        if ($request->hasFile('importFileName4')) {
            $noop = false;
            $file = 'setupIncH_Team=' . $teamId . '_' . getTimestamp() . '.csv';
            $request->file('importFileName4')->storeAs($file);
            $r = ImportHIncumbents($file);
            $r['ok'] ? $lines[]  = "Incumbent history: {$r['inserted']} imported."
                     : $errors[] = "Incumbent history: {$r['error']}";
        }

        if ($request->hasFile('importFileName5')) {
            $noop = false;
            $file = 'setupIncC_Team=' . $teamId . '_' . getTimestamp() . '.csv';
            $request->file('importFileName5')->storeAs($file);
            // ImportIncumbentChanges not yet implemented
            $errors[] = 'Incumbent Changes: import not yet implemented.';
        }

        if ($noop) {
            return redirect()->back()->with('warning', 'No file was selected.');
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->with('error', implode(' ', $errors))
                ->with('success', empty($lines) ? null : implode(' ', $lines));
        }

        return redirect()->back()->with('success', implode(' ', $lines));
    }
}
