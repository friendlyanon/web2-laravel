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
            $this->addOrganization($table);
        });

        Schema::table('partner_groups', function (Blueprint $table) {
            $this->addOrganization($table);
        });

        Schema::table('products', function (Blueprint $table) {
            $this->addOrganization($table);
        });

        Schema::table('taxes', function (Blueprint $table) {
            $this->addOrganization($table);
        });

        Schema::table('discounts', function (Blueprint $table) {
            $this->addOrganization($table);
        });

        Schema::table('products', function (Blueprint $table) {
            $this->foreign($table, 'tax_id');
            $this->addOrganization($table);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $this->foreign($table, 'partner_id');
            $this->foreign($table, 'product_id');
            $this->foreign($table, 'discount_id');
            $this->addOrganization($table);
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
            $table->dropForeign('organization_id');
        });

        Schema::table('partner_groups', static function (Blueprint $table) {
            $table->dropForeign('organization_id');
        });

        Schema::table('products', static function (Blueprint $table) {
            $table->dropForeign('organization_id');
        });

        Schema::table('taxes', static function (Blueprint $table) {
            $table->dropForeign('organization_id');
        });

        Schema::table('discounts', static function (Blueprint $table) {
            $table->dropForeign('organization_id');
        });

        Schema::table('products', static function (Blueprint $table) {
            $table->dropForeign('tax_id');
            $table->dropForeign('organization_id');
        });

        Schema::table('invoices', static function (Blueprint $table) {
            $table->dropForeign('partner_id');
            $table->dropForeign('product_id');
            $table->dropForeign('discount_id');
            $table->dropForeign('organization_id');
        });
    }

    protected function addOrganization(Blueprint $table)
    {
        $this->foreign($table, 'organization_id');
    }

    protected function foreign(Blueprint $table, string $column)
    {
        $name = Str::plural(substr($column, 0, strpos($column, '_id')));
        $table->foreign($column)->references('id')->on($name)
            ->onDelete('SET NULL');
    }
}
