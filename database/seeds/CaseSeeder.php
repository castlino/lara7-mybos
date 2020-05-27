<?php

use Illuminate\Database\Seeder;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('cases')->insert([
          'case_number' => 20,
          'subject' => 'Oiling woodwork',
          'type' => 'Upgrades',
          'status' => 'Completed',
          'contractors' => 'ABC Construction',
          'priority' => 'low',
          'description' => 'Repair work',
          'added_date' => now(),
          'due_date' => now()->addMonthsNoOverflow(2)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 21,
          'subject' => 'Lobby Repair',
          'type' => 'Defects',
          'status' => 'In Progress',
          'contractors' => 'XZY Construction',
          'priority' => 'high',
          'description' => 'broken tiles',
          'added_date' => now()->addDays(-78),
          'due_date' => now()->addMonthsNoOverflow(3)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 22,
          'subject' => 'Maintenance',
          'type' => 'Defects',
          'status' => 'New',
          'contractors' => 'Cleaning Men',
          'priority' => 'Urgent',
          'description' => 'Moulds in ceilings',
          'added_date' => now()->addDays(-78),
          'due_date' => now()->addMonthsNoOverflow(3)->format('Y-m-d H:i:s'),
      ]);
      
    }
}
