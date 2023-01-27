<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_poster')->default(true)->change();
            $this->updateOptionForUsers();


        });
    }


    private function updateOptionForUsers(): void
    {
        foreach (User::all() as $item) {
            $item->update(['show_poster' => true]);
            $item->save();
        }
    }
};
