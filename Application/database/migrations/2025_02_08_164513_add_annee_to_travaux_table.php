<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('travaux', function (Blueprint $table) {
            $table->year('annee')->after('fichier'); // Ajout du champ après le fichier
        });
    }

    public function down()
    {
        Schema::table('travaux', function (Blueprint $table) {
            $table->dropColumn('annee');
        });
    }
};
