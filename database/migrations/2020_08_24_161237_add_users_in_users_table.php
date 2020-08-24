<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\User;

class AddUsersInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user1 = new User([
            'name' => 'Maria',
            'email' => 'maria@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $user1->save();

        $user2 = new User([
            'name' => 'Joao',
            'email' => 'joao@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $user2->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
