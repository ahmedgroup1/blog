<?php

namespace Ahmed\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase {

    public function testIndexAction() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $link = $crawler->filter('a:contains("Android")')->eq(1)->link();
        $crawler = $client->click($link);

        $this->assertGreaterThan(0, $crawler->filter('html:contains("touchscreen")')->count());

        $form = $crawler->selectButton('submit')->form();

        // set some values
        $form['name'] = 'Lucas';
        $form['form_name[subject]'] = 'Hey there!';

        // submit the form
        $crawler = $client->submit($form);
    }

    /*
      public function testCompleteScenario()
      {
      // Create a new client to browse the application
      $client = static::createClient();

      // Create a new entry in the database
      $crawler = $client->request('GET', '/post/');
      $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /post/");
      $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

      // Fill in the form and submit it
      $form = $crawler->selectButton('Create')->form(array(
      'ahmed_blogbundle_post[field_name]'  => 'Test',
      // ... other fields to fill
      ));

      $client->submit($form);
      $crawler = $client->followRedirect();

      // Check data in the show view
      $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

      // Edit the entity
      $crawler = $client->click($crawler->selectLink('Edit')->link());

      $form = $crawler->selectButton('Update')->form(array(
      'ahmed_blogbundle_post[field_name]'  => 'Foo',
      // ... other fields to fill
      ));

      $client->submit($form);
      $crawler = $client->followRedirect();

      // Check the element contains an attribute with value equals "Foo"
      $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

      // Delete the entity
      $client->submit($crawler->selectButton('Delete')->form());
      $crawler = $client->followRedirect();

      // Check the entity has been delete on the list
      $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
      }

     */
}
