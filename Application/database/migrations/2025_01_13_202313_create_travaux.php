<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravaux extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travaux', function (Blueprint $table) {
            $table->id();
            $table->string('sujet');
            $table->string('fichier');
            $table->date('date_depot');
            $table->string('statut')->default('en attente');
            $table->date('date_validation')->nullable();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->foreignId('bibliothecaire_id')->nullable()->constrained('bibliothecaires')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travaux');
    }
}
