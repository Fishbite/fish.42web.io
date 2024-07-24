<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Web Development | Fishbite</title>
    <link rel="stylesheet" href="styles/main.css" />
  </head>
  <body>
    <div class="main">
      <header>
        <h1 class="center title"><?=$title?></h1>
        <p class="center">Anything you need...</p>
        <p class="center">...we'll be with you shortly!</p>
      </header>
      

      <div class="container center">
        
        <article class="container frame image">
          <!-- <img class="hair-img" src="images/hair-long-brown.svg" alt="hair long brown" /> -->
          <!-- <figcaption>
            <strong style="font-size: 2rem"><?= $joe ?></strong>
          </figcaption> -->
        </article>
        
        <article class="container frame text">
          <p class="fat-p-top">
            For all your web development needs...
          </p>

            <ul class="list">
              <li unselectable="on" class="listElement" data-tooltip="unifying the idea or theme of your website &mdash; especially for a product or service">Concept</li>
              <li class="listElement" data-tooltip="the purpose the website is designed for and the tasks it is expected to perform">functionality</li>
              <li class="listElement" data-tooltip="the plan and fashion of the form and structure of your website">Design</li>
              <li class="listElement" data-tooltip="the ones 'n' zeros 0110 1101 0101 1010 0001 that we take care of to make your website work">Programming</li>
              <li class="listElement" data-tooltip="making sure that Google bot and other search engines like you website">SEO</li>
              <li class="listElement" data-tooltip="we'll find the perfect home for your website with everything it needs to work within your budget ">hosting</li>
            </ul>
          
          <p class="fat-p-bottom">...all you need is Fishbite.</p>
        </article>

      </div>

      <article>
      <h1 class="title center"><?= $title ?></h1>
      <p class="center bottom-pad">You ready for this?</p>
      </article>
      
    </div>
