<?php

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entity = new Entity();
        $entity->ref_entity = 1;
        $entity->name = "ent01";
        $entity->save();
    }
}
