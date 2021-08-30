<?php

require 'vendor/autoload.php';
require 'bootstrap.php';
use Kresonja\Ontologija;
use Composer\Autoload\ClassLoader;

Flight::route('/', function(){

  $foaf = \EasyRdf\Graph::newAndLoad('https://oziz.ffos.hr/nastava20202021/mkresonja_20/ontologija/kresonja_rdf/mkresonja.rdf');
  $info = $foaf->dump();
  echo "<h2>Ontologija korištena za projektni zadatak iz P3:</h2> <br/><br/>" . $info;
});

Flight::route('GET /search', function () {

  $doctrineBootstrap = Flight::entityManager();
  $em = $doctrineBootstrap->getEntityManager();
  $repozitorij = $em->getRepository('Kresonja\Ontologija');
  $zapisi = $repozitorij->findAll();
  echo $doctrineBootstrap->getJson($zapisi);
});

Flight::route(
  'GET /fill_table', function () {

    $foaf = \EasyRdf\Graph::newAndLoad('https://oziz.ffos.hr/nastava20202021/mkresonja_20/ontologija/kresonja_rdf/mkresonja.rdf');

    foreach ($foaf->resources() as $resource) {

        $i = 0;
        $naslov = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#imaNaziv>');
        $autor = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#imaIme>');
        $izdavac = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#izdavac>');
        $zanr = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#zanr>');
      //  $godinaIzdanja = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#godinaIzdanja>');
        $brojStranica = ''.$foaf->get($resource, '<http://oziz.ffos.hr/mkresonja/ontologija-fb#brojStranica>');


        $ontologija = new Ontologija();
        $ontologija->setPodaci(Flight::request()->data);

        $ontologija->setNaslov($naslov);
        $ontologija->setAutor($autor);
        $ontologija->setIzdavac($izdavac);
        $ontologija->setZanr($zanr);
      //  $ontologija->setGodinaIzdanja($godinaIzdanja);
        $ontologija->setBrojStranica($brojStranica);


        $doctrineBootstrap = Flight::entityManager();
        $em = $doctrineBootstrap->getEntityManager();
  
        $em->persist($ontologija);
        $em->flush();
      }

      echo "Svaka čast, legendo!";

});

Flight::route('GET /search/@naslov', function($naslov){

  $doctrineBootstrap = Flight::entityManager();
  $em = $doctrineBootstrap->getEntityManager();
  $repozitorij=$em->getRepository('Kresonja\Ontologija');
  $zapisi = $repozitorij->createQueryBuilder('p')
                        ->where('p.naslov LIKE :naslov')
                        ->setParameter('naslov', '%'.$naslov.'%')
                        ->getQuery()
                        ->getResult();
  echo $doctrineBootstrap->getJson($zapisi);

});


$cl = new ClassLoader('Kresonja', __DIR__, '/src');
$cl->register();
require_once 'bootstrap.php';
Flight::register('entityManager','DoctrineBootstrap');

Flight::start();
?>