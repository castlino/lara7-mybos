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
          'type' => 'gardening',
          'status' => 'Completed',
          'contractors' => 'ABC Construction',
          'priority' => 'Low',
          'description' => 'Repair work',
          'starred' => true,
          'trashed' => false,
          'added_date' => now(),
          'due_date' => now()->addMonthsNoOverflow(2)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 21,
          'subject' => 'Lobby Repair',
          'type' => 'Defects',
          'status' => 'In Progress',
          'contractors' => 'XZY Construction',
          'priority' => 'High',
          'description' => 'broken tiles',
          'starred' => false,
          'trashed' => false,
          'added_date' => now()->addDays(-78),
          'due_date' => now()->addMonthsNoOverflow(3)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 22,
          'subject' => 'Maintenance',
          'type' => 'Renovations',
          'status' => 'In Progress',
          'contractors' => 'Cleaning Men',
          'priority' => 'Urgent',
          'description' => 'Moulds in ceilings',
          'starred' => false,
          'trashed' => false,
          'added_date' => now()->addDays(-8),
          'due_date' => now()->addMonthsNoOverflow(3)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 23,
          'subject' => 'Wall leaking with water.',
          'type' => 'Repair & Maintenance',
          'status' => 'Awaiting Contractor',
          'contractors' => 'Repair Men',
          'priority' => 'Urgent',
          'description' => 'Burst pipe in between walls',
          'starred' => true,
          'trashed' => false,
          'added_date' => now()->addDays(-4),
          'due_date' => now()->addMonthsNoOverflow(2)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 24,
          'subject' => 'Repair of broken Door',
          'type' => 'Repair & Maintenance',
          'status' => 'In Progress',
          'contractors' => 'Repair Men',
          'priority' => 'Medium',
          'description' => 'Door vandalised by burlgars',
          'starred' => false,
          'trashed' => false,
          'added_date' => now()->addDays(-1),
          'due_date' => now()->addMonthsNoOverflow(1)->format('Y-m-d H:i:s'),
      ]);
      
      DB::table('cases')->insert([
          'case_number' => 25,
          'subject' => 'Repair of wooden swing',
          'type' => 'Repair & Maintenance',
          'status' => 'In Progress',
          'contractors' => 'Repair Men',
          'priority' => 'Low',
          'description' => 'Just normal repair',
          'starred' => false,
          'trashed' => false,
          'added_date' => now()->addDays(-5),
          'due_date' => now()->addMonthsNoOverflow(8)->format('Y-m-d H:i:s'),
      ]);
      
    }
}
