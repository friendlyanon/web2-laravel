<?php

use App\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', static function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('total');
            $table->enum('status', [
                Invoice::STATUS_OPEN,
                Invoice::STATUS_CLOSED,
                Invoice::STATUS_PAID,
                Invoice::STATUS_RECTIFIED,
            ])->default(Invoice::STATUS_OPEN);
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->timestamp('expires_at');
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
