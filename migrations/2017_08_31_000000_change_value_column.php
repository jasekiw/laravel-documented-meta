<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class ChangeValueColumn
 */
class ChangeValueColumn extends Migration
{
    /**
     * The table builder
     * @var Builder
     */
    protected $builder;

    /**
     * Inject Builder
     */
    public function __construct()
    {
        $this->builder = app()->make(Builder::class);
    }

    /**
     * Create the table
     */
    public function up() {
       $this->builder->table('documented_meta', function(Blueprint $table) {
           $table->text('value')->change();
       });

    }

    /**
     * Drop the table
     */
    public function down() {

    }
}