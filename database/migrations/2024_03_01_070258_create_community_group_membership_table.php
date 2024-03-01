<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('community_group_community_membership', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('community_group_id');
            $table->unsignedBiginteger('community_membership_id');


            $table->foreign('community_group_id')->references('id')
                 ->on('community_groups')->onDelete('cascade');
            $table->foreign('community_membership_id')->references('id')
                ->on('community_memberships')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_group_community_membership');
    }
};
