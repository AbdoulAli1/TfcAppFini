<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotifRejetToTravauxTable extends Migration
{
    public function up()
    {
        Schema::table('travaux', function (Blueprint $table) {
            $table->text('motif_rejet')->nullable()->after('statut'); // Ajouter le champ motif_rejet
        });
    }

    public function down()
    {
        Schema::table('travaux', function (Blueprint $table) {
            $table->dropColumn('motif_rejet');
        });
    }
}
