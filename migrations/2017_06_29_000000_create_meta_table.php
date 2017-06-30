<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
class CreateMetaTable extends Migration
{
    protected $builder;

    /**
     * CreateMetaTable constructor.
     */
    public function __construct()
    {
        $this->builder = app()->make(Builder::class);
    }

    public function up() {
       $this->builder->create('documented_meta', function(Blueprint $table) {
           $table->increments('id');
           $table->unsignedInteger('subject_id');
           $table->string('type');
           $table->string('value')->nullable();
       });

    }
    public function down() {
        $this->builder->drop('documented_meta');
    }
}