<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([ 
            'title' => 'Cien Años de Soledad', 
            'author' => 'Gabriel García Márquez', 
            'category' => 'Ficción', 
            'synopsis' => 'Una historia épica de la familia Buendía en el pueblo ficticio de Macondo.', 
            'published_at' => '1967-05-30' 
        ]); 

        Book::create([ 
            'title' => 'El Amor en los Tiempos del Cólera', 
            'author' => 'Gabriel García Márquez', 
            'category' => 'Romance', 
            'synopsis' => 'Una historia de amor entre Fermina Daza y Florentino Ariza, que se desarrolla a lo largo de varias décadas.', 
            'published_at' => '1985-10-05' 
        ]); 
        
        Book::create([ 
            'title' => '1984', 
            'author' => 'George Orwell', 
            'category' => 'Distopía', 
            'synopsis' => 'Una novela que explora un futuro distópico bajo un régimen totalitario.', 
            'published_at' => '1949-06-08' 
        ]); 
        
        Book::create([ 
            'title' => 'Don Quijote de la Mancha', 
            'author' => 'Miguel de Cervantes', 
            'category' => 'Clásico', 
            'synopsis' => 'Las aventuras del ingenioso hidalgo Don Quijote y su escudero Sancho Panza.', 
            'published_at' => '1605-01-16' 
        ]); 
        
        Book::create([ 
            'title' => 'Orgullo y Prejuicio', 
            'author' => 'Jane Austen', 
            'category' => 'Romance', 
            'synopsis' => 'La historia de Elizabeth Bennet y su complejo romance con el Sr. Darcy.', 
            'published_at' => '1813-01-28' 
        ]);
        
        Book::create([
            'title' => 'Matar a un Ruiseñor', 
            'author' => 'Harper Lee', 
            'category' => 'Drama', 
            'synopsis' => 'Un poderoso relato sobre la justicia y el racismo en el sur de Estados Unidos.', 
            'published_at' => '1960-07-11'
        ]);

        Book::create([ 
            'title' => 'Posdata: Te Amo', 
            'author' => 'Cecelia Ahern', 
            'category' => 'Romance', 
            'synopsis' => 'Una conmovedora historia sobre el amor y la pérdida, centrada en una joven viuda que recibe cartas de su difunto esposo.', 
            'published_at' => '2004-01-01'
        ]);
    }
}
