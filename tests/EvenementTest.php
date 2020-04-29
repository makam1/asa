<?php
namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class EvenementTest extends WebTestCase
{
   public function testAjoutEvenement()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'makam12',
            'PHP_AUTH_PW'=>'passer'
        ]);
        $client->request('POST', '/api/evenement',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "libelle":"rendez-vous médical",
            "descriptif":"rendez-vous chez le médecin",
            "datedebut":"05-05-2020",
            "datefin":"05-05-2020",
            "heuredebut":"10:00",
            "heurefin":"",
            "statut":"test"
            }'   
    );
    $a=$client->getResponse();
    var_dump($a);
    $this->assertSame(200,$client->getResponse()->getStatusCode());
    }
}