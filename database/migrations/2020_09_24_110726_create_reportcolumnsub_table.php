<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reportgroups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('reportid');
            $table->decimal('columnorder', 5, 0)->default(10);
            $table->string('field', 30);
            $table->string('header', 100);
            $table->string('sortable', 1)->default('Y');
            $table->decimal('sortorder', 3, 0)->default(0);
            $table->decimal('grouporder', 3, 0)->default(0);
            $table->string('subtotal', 1)->default('N');
            $table->string('total', 1)->default('N');
            $table->string('count', 1)->default('N');
            $table->string('hidden', 1)->default('N');
        });

        // Position Listing (1000) — group by company, location, department with count and budget totals
        DB::table('reportgroups')->insert([['reportid'=>'1000','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1000','columnorder'=>'20','field'=>'level1','header'=>'Location'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1000','columnorder'=>'30','field'=>'level2','header'=>'Department'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1000','columnorder'=>'40','field'=>'count','header'=>'Count'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1000','columnorder'=>'50','field'=>'sumbudgsal','header'=>'Budgeted Salary'],]);

        // Position Reports To (1010)
        DB::table('reportgroups')->insert([['reportid'=>'1010','columnorder'=>'10','field'=>'company','header'=>'Company'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1010','columnorder'=>'20','field'=>'posno','header'=>'Pos #'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1010','columnorder'=>'30','field'=>'descr','header'=>'Pos Name'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1010','columnorder'=>'40','field'=>'level1','header'=>'Department'],]);
        DB::table('reportgroups')->insert([['reportid'=>'1010','columnorder'=>'50','field'=>'curstatus','header'=>'Status'],]);
    }

    public function down()
    {
        Schema::dropIfExists('reportgroups');
    }
};
