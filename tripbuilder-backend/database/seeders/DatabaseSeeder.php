<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Airline::create([
            'code' => 'AC',
            'name' => 'Air Canada'
        ]);
        Airline::create([
            'code' => 'FLE',
            'name' => 'Flair Airlines'
        ]);
        Airline::create([
            'code' => 'WS',
            'name' => 'WestJet'
        ]);
        Airline::create([
            'code' => 'TS',
            'name' => 'Air Transat'
        ]);

        Airport::create([
            'code' => 'YUL',
            'city_code' => 'YMQ',
            'name' => 'Pierre Elliott Trudeau International',
            'city' => 'Montreal',
            'country_code' => 'CA',
            'latitude' => 45.457714,
            'longitude' => -73.749908,
            'timezone' => 'America/Montreal',
        ]);
        Airport::create([
            'code' => 'YVR',
            'city_code' => 'YVR',
            'name' => 'Vancouver International',
            'city' => 'Vancouver',
            'country_code' => 'CA',
            'latitude' => 49.194698,
            'longitude' => -123.179192,
            'timezone' => 'America/Vancouver',
        ]);
        Airport::create([
            'code' => 'YYZ',
            'city_code' => 'YYZ',
            'name' => 'Toronto Pearson International',
            'city' => 'Toronto',
            'country_code' => 'CA',
            'latitude' => 43.6797,
            'longitude' => -79.6227,
            'timezone' => 'America/Toronto',
        ]);
        Airport::create([
            'code' => 'YYC',
            'city_code' => 'YYC',
            'name' => 'Calgary International',
            'city' => 'Calgary',
            'country_code' => 'CA',
            'latitude' => 51.1308,
            'longitude' => -114.0131,
            'timezone' => 'America/Edmonton',
        ]);

        Flight::create([
            'airline' => 'AC',
            'number' => '301',
            'departure_airport' => 'YUL',
            'departure_time' => '07:30',
            'arrival_airport' => 'YVR',
            'duration' => 330,
            'price' => 600.31,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '304',
            'departure_airport' => 'YVR',
            'departure_time' => '08:55',
            'arrival_airport' => 'YUL',
            'duration' => 277,
            'price' => 499.93,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '200',
            'departure_airport' => 'YUL',
            'departure_time' => '01:00',
            'arrival_airport' => 'YVR',
            'duration' => 330,
            'price' => 189.00,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '400',
            'departure_airport' => 'YUL',
            'departure_time' => '09:15',
            'arrival_airport' => 'YYZ',
            'duration' => 90,
            'price' => 225.45,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '410',
            'departure_airport' => 'YYZ',
            'departure_time' => '12:20',
            'arrival_airport' => 'YYC',
            'duration' => 240,
            'price' => 375.50,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '210',
            'departure_airport' => 'YUL',
            'departure_time' => '03:30',
            'arrival_airport' => 'YYC',
            'duration' => 300,
            'price' => 240.25,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '212',
            'departure_airport' => 'YVR',
            'departure_time' => '13:15',
            'arrival_airport' => 'YYZ',
            'duration' => 260,
            'price' => 300.99,
        ]);
        Flight::create([
            'airline' => 'WS',
            'number' => '115',
            'departure_airport' => 'YUL',
            'departure_time' => '14:45',
            'arrival_airport' => 'YYZ',
            'duration' => 95,
            'price' => 230.20,
        ]);
        Flight::create([
            'airline' => 'WS',
            'number' => '160',
            'departure_airport' => 'YVR',
            'departure_time' => '15:30',
            'arrival_airport' => 'YYC',
            'duration' => 160,
            'price' => 280.75,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '45',
            'departure_airport' => 'YUL',
            'departure_time' => '16:15',
            'arrival_airport' => 'YVR',
            'duration' => 335,
            'price' => 270.60,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '48',
            'departure_airport' => 'YYZ',
            'departure_time' => '19:10',
            'arrival_airport' => 'YUL',
            'duration' => 85,
            'price' => 215.35,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '420',
            'departure_airport' => 'YYZ',
            'departure_time' => '10:45',
            'arrival_airport' => 'YVR',
            'duration' => 265,
            'price' => 320.45,
        ]);
        Flight::create([
            'airline' => 'WS',
            'number' => '170',
            'departure_airport' => 'YYC',
            'departure_time' => '17:25',
            'arrival_airport' => 'YUL',
            'duration' => 300,
            'price' => 295.75,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '50',
            'departure_airport' => 'YVR',
            'departure_time' => '20:00',
            'arrival_airport' => 'YYZ',
            'duration' => 250,
            'price' => 310.20,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '215',
            'departure_airport' => 'YYC',
            'departure_time' => '04:30',
            'arrival_airport' => 'YVR',
            'duration' => 145,
            'price' => 190.50,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '430',
            'departure_airport' => 'YYC',
            'departure_time' => '09:45',
            'arrival_airport' => 'YUL',
            'duration' => 260,
            'price' => 305.65,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '440',
            'departure_airport' => 'YVR',
            'departure_time' => '11:25',
            'arrival_airport' => 'YYZ',
            'duration' => 250,
            'price' => 320.80,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '220',
            'departure_airport' => 'YYZ',
            'departure_time' => '03:50',
            'arrival_airport' => 'YYC',
            'duration' => 230,
            'price' => 225.25,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '222',
            'departure_airport' => 'YUL',
            'departure_time' => '14:10',
            'arrival_airport' => 'YVR',
            'duration' => 330,
            'price' => 310.55,
        ]);
        Flight::create([
            'airline' => 'WS',
            'number' => '180',
            'departure_airport' => 'YYZ',
            'departure_time' => '16:00',
            'arrival_airport' => 'YUL',
            'duration' => 80,
            'price' => 235.40,
        ]);
        Flight::create([
            'airline' => 'WS',
            'number' => '190',
            'departure_airport' => 'YVR',
            'departure_time' => '17:15',
            'arrival_airport' => 'YYC',
            'duration' => 150,
            'price' => 270.95,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '55',
            'departure_airport' => 'YYZ',
            'departure_time' => '18:45',
            'arrival_airport' => 'YUL',
            'duration' => 85,
            'price' => 220.45,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '60',
            'departure_airport' => 'YYC',
            'departure_time' => '20:30',
            'arrival_airport' => 'YVR',
            'duration' => 140,
            'price' => 260.10,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '230',
            'departure_airport' => 'YUL',
            'departure_time' => '21:45',
            'arrival_airport' => 'YYZ',
            'duration' => 90,
            'price' => 205.75,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '235',
            'departure_airport' => 'YYC',
            'departure_time' => '23:00',
            'arrival_airport' => 'YUL',
            'duration' => 250,
            'price' => 315.20,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '310',
            'departure_airport' => 'YUL',
            'departure_time' => '06:45',
            'arrival_airport' => 'YVR',
            'duration' => 328,
            'price' => 605.20,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '205',
            'departure_airport' => 'YUL',
            'departure_time' => '02:30',
            'arrival_airport' => 'YVR',
            'duration' => 325,
            'price' => 190.50,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '405',
            'departure_airport' => 'YUL',
            'departure_time' => '11:00',
            'arrival_airport' => 'YVR',
            'duration' => 330,
            'price' => 650.75,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '315',
            'departure_airport' => 'YUL',
            'departure_time' => '09:15',
            'arrival_airport' => 'YVR',
            'duration' => 329,
            'price' => 610.45,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '211',
            'departure_airport' => 'YUL',
            'departure_time' => '03:45',
            'arrival_airport' => 'YVR',
            'duration' => 332,
            'price' => 195.35,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '410',
            'departure_airport' => 'YUL',
            'departure_time' => '12:30',
            'arrival_airport' => 'YVR',
            'duration' => 328,
            'price' => 655.90,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '320',
            'departure_airport' => 'YUL',
            'departure_time' => '13:45',
            'arrival_airport' => 'YVR',
            'duration' => 327,
            'price' => 600.70,
        ]);
        Flight::create([
            'airline' => 'FLE',
            'number' => '216',
            'departure_airport' => 'YUL',
            'departure_time' => '05:30',
            'arrival_airport' => 'YVR',
            'duration' => 331,
            'price' => 198.45,
        ]);
        Flight::create([
            'airline' => 'TS',
            'number' => '415',
            'departure_airport' => 'YUL',
            'departure_time' => '14:15',
            'arrival_airport' => 'YVR',
            'duration' => 329,
            'price' => 660.85,
        ]);
        Flight::create([
            'airline' => 'AC',
            'number' => '325',
            'departure_airport' => 'YUL',
            'departure_time' => '16:00',
            'arrival_airport' => 'YVR',
            'duration' => 330,
            'price' => 613.60,
        ]);
    }
}
