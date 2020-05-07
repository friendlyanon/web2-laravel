<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $this->foreign($table, 'partner_group_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $this->foreign($table, 'tax_id');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $this->foreign($table, 'partner_id');
            $this->foreign($table, 'product_id');
            $this->foreign($table, 'discount_id');
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

    protected function foreign(Blueprint $table, string $column)
    {
        $name = Str::plural(substr($column, 0, strpos($column, '_id')));
        $table->foreign($column)->references('id')->on($name)
            ->onDelete('SET NULL');
    }
}
