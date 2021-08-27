<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateKadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kader', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('ktp')->nullable();
            $table->string('nomor_urut')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->boolean('jenis_kelamin');
            $table->string('pendidikan');
            $table->string('alamat');
            $table->bigInteger('regencies_id');
            $table->bigInteger('districts_id');
            $table->bigInteger('villages_id');
            $table->string('telp');
            $table->string('job');
            $table->date('awal_anggota');
            $table->bigInteger('jenjang_anggota');
            $table->date('usia_jenjang');
            $table->boolean('pembina');
            $table->bigInteger('id_pembina')->nullable();
            $table->string('nama_pembina')->nullable();
            $table->bigInteger('pasangan_id')->nullable();
            $table->string('pasangan')->nullable();
            $table->string('status_pernikahan');
            $table->bigInteger('ortu_id')->nullable();
            $table->string('darah');
            $table->string('amanah')->nullable();
            $table->boolean('verif');
            $table->dateTime('verif_at')->nullable();
            $table->bigInteger('verif_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kader');
    }
}
