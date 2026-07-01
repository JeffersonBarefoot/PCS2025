<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('reportid');
            $table->unsignedBigInteger('teamid')->nullable();   // null = system report visible to all teams
            $table->unsignedBigInteger('userid')->nullable();   // null = system report; set for user-created reports
            $table->string('active', 1)->default('A');
            $table->string('private', 1)->default('N');         // Y = visible only to userid; admins bypass
            $table->boolean('is_system')->default(false);       // true = read-only template; copy to customize
            $table->string('group1', 30)->default('');          // report type: POS, INC, BUDG, etc.
            $table->string('group2', 30)->default('');
            $table->string('sortorder', 10)->default('');
            $table->string('descr', 75)->default('');
            $table->string('notes', 250)->default('');
        });

        // Position Reports
        DB::table('reports')->insert(['active'=>'A','group1'=>'POS','group2'=>'1','reportid'=>'1000','sortorder'=>'1000','descr'=>'Position Listing','notes'=>'Positions by Vacant, Partially Filled, Filled, Overfilled','is_system'=>true]);
        DB::table('reports')->insert(['active'=>'A','group1'=>'POS','group2'=>'1','reportid'=>'1010','sortorder'=>'1010','descr'=>'Position Reports To','notes'=>'','is_system'=>true]);
        DB::table('reports')->insert(['active'=>'A','group1'=>'POS','group2'=>'1','reportid'=>'1020','sortorder'=>'1020','descr'=>'Position Direct Reports','notes'=>'Summary Listing of Incumbents','is_system'=>true]);
        DB::table('reports')->insert(['active'=>'A','group1'=>'POS','group2'=>'1','reportid'=>'1030','sortorder'=>'1030','descr'=>'Positions by Filled Status','notes'=>'','is_system'=>true]);

        // Position History Reports

        // Incumbent Reports
        DB::table('reports')->insert(['active'=>'A','group1'=>'INC','group2'=>'1','reportid'=>'3000','sortorder'=>'3000','descr'=>'Incumbent Listing','notes'=>'','is_system'=>true]);

        // Incumbent History Reports

        // Budget Reports
        DB::table('reports')->insert(['active'=>'A','group1'=>'BUDG','group2'=>'1','reportid'=>'5000','sortorder'=>'5000','descr'=>'Budget Listing','notes'=>'','is_system'=>true]);

        // Vacancy Reports

        // Recruiting Reports








    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
