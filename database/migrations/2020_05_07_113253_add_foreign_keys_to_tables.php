<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTables extends Migration
{
    protected const RELATIONS = [
        'partners' => ['partner_group'],
        'partner_groups' => [],
        'taxes' => [],
        'discounts' => [],
        'products' => ['tax'],
        'invoices' => ['partner', 'product', 'discount'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $keys = [];
        $callback = function (Blueprint $table) use (&$keys) {
            $this->addOrganization($table);
            foreach ($keys as $key) {
                $this->foreign($table, $key);
            }
        };
        foreach (self::RELATIONS as $table => $keys) {
            Schema::table($table, $callback);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $keys = [];
        $callback = static function (Blueprint $table) use (&$keys) {
            $table->dropForeign('organization_id');
            foreach ($keys as $key) {
                $table->dropForeign($key . '_id');
            }
        };
        foreach (self::RELATIONS as $table => $keys) {
            Schema::table($table, $callback);
        }
    }

    protected function addOrganization(Blueprint $table)
    {
        $this->foreign($table, 'organization', 'CASCADE');
    }

    protected function foreign(
        Blueprint $table,
        string $key,
        string $onDelete = 'SET NULL'
    ) {
        $name = Str::plural($key);
        $table->foreign($key . '_id')->references('id')->on($name)
            ->onDelete($onDelete);
    }
}
