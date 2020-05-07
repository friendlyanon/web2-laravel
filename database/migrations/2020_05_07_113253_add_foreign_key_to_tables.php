<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', static function (Blueprint $table) {
            $table->foreignId('partner_group_id')->constrained();
        });

        Schema::table('products', static function (Blueprint $table) {
            $table->foreignId('tax_id')->constrained();
        });

        Schema::table('invoices', static function (Blueprint $table) {
            $table->foreignId('partner_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('discount_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', static function (Blueprint $table) {
            $table->dropForeign('partner_group_id');
        });

        Schema::table('products', static function (Blueprint $table) {
            $table->dropForeign('tax_id');
        });

        Schema::table('invoices', static function (Blueprint $table) {
            $table->dropForeign('partner_id');
            $table->dropForeign('product_id');
            $table->dropForeign('discount_id');
        });
    }
}
