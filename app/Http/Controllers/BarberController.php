<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Barber;
use App\Models\BarberPhotos;
use App\Models\BarberServices;
use App\Models\BarberTestimonial;
use App\Models\BarberAvailability;


class BarberController extends Controller
{
    private $loggedUser;

    public function __construct() {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function createRandom() {
        $array = ['error' => ''];

        for($q = 0; $q < 15; $q++) {
            $names = ['Bonieky', 'Paulo', 'Pedro', 'Amanda', 'Clarice', 'Gabriel', 'Flavia', 'Letícia', 'Samara', 'Bianca', 'Gustavo', 'Samantha', 'Guilherme', 'Vitor', 'Laura'];
            $lastnames = ['Lacerda', 'Silva', 'Diniz', 'Alvaro', 'Santos', 'Bianchinni', 'Medeiros', 'Menezes', 'Lima', 'Bitencourt', 'Alvarenga', 'Lins', 'Ludovik', 'Pior', 'Paim'];

            $servicos = ['Corte', 'Pintura', 'Aparação', 'Enfeite'];
            $servicos2 = ['Cabelo', 'Unha', 'Pernas', 'Sobrancelhas'];

            $depos = [
                'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
                'Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words.',
                'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.',
                'This book is a treatise on the theory of ethics, very popular during the Renaissance.',
                'Lorem Ipsum used since the 1500s is reproduced below for those interested.'
            ];

            $newBarber = new Barber();
            $newBarber->name = $names[rand(0, count($names)-1)].' '.$lastnames[rand(0, count($lastnames)-1)];
            $newBarber->avatar = rand(1, 4).'.png';
            $newBarber->stars = rand(2, 4).'.'.rand(0, 9);
            $newBarber->latitude = '-23.5'.rand(0, 9).'30907';
            $newBarber->longitude = '-46.6'.rand(0, 9).'82795';
            $newBarber->save();

            $ns = rand(3, 6);

            for ($w = 0; $w < 4; $w++) { 
                $newBarberPhoto = new BarberPhotos();
                $newBarberPhoto->id_barber = $newBarber->id;
                $newBarberPhoto->url = rand(1, 5).'.png';
                $newBarberPhoto->save();
            }

            for ($w = 0; $w < $ns; $w++) { 
                $newBarberServices = new BarberServices();
                $newBarberServices->id_barber = $newBarber->id;
                $newBarberServices->name = $servicos[rand(0, count($servicos)-1)].' de '.$servicos2[rand(0, count($servicos2)-1)];
                $newBarberServices->price = rand(1, 99).'.'.rand(0, 100);
                $newBarberServices->save();
            }

            for ($w = 0; $w < 3; $w++) { 
                $newBarberTestimonial = new BarberTestimonial();
                $newBarberTestimonial->id_barber = $newBarber->id;
                $newBarberTestimonial->name = $names[rand(0, count($names)-1)].' '.$lastnames[rand(0, count($lastnames)-1)];
                $newBarberTestimonial->rate = rand(2, 4).'.'.rand(0, 9);
                $newBarberTestimonial->body = $depos[rand(0, count($depos)-1)];
                $newBarberTestimonial->save();
            }

            for ($e=0; $e < 4; $e++) { 
                $rAdd = rand(7, 10);
                $hours = [];
                for ($r=0; $r < 8; $r++) { 
                    $time = $r + $rAdd;
                    if($time < 10) {
                        $time = '0'.$time;
                    }
                    $hours[] = $time.':00';
                }
                $newBaberAvail = new BarberAvailability();
                $newBaberAvail->id_barber = $newBarber->id;
                $newBaberAvail->weekday = $e;
                $newBaberAvail->hours = implode(',',$hours);
                $newBaberAvail->save();
            }
        }

        return $array;        
    }
}
