<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateMetaTable
 */
class CreateMetaTable extends Migration
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
       $this->builder->create('documented_meta', function(Blueprint $table) {
           $table->increments('id');
           $table->unsignedInteger('subject_id');
           $table->string('type');
           $table->string('key');
           $table->string('value')->nullable();
           $table->timestamps();
       });

    }

    /**
     * Drop the table
     */
    public function down() {
        $this->builder->drop('documented_meta');
    }
}