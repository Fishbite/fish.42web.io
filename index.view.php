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
        
        <article class="container frame">
          <img class="hair-img" src="images/hair-long.svg" alt="hair long" />
          <figcaption>
            <strong style="font-size: 2rem"><?= $joe ?></strong>
          </figcaption>
        </article>
        
        <article class="container frame text">
          <p class="fat-p-top">
            For all your web development needs...
          </p>

            <ul class="">
              <li>Concept</li>
              <li>functionality</li>
              <li>Design</li>
              <li>Programming</li>
              <li>SEO</li>
              <li>hosting</li>
            </ul>
          
          <p class="fat-p-bottom">...all you need is Fishbite.</p>
        </article>

      </div>

      <article>
      <h1 class="title center"><?= $title ?></h1>
      <p class="center bottom-pad">You ready for this?</p>
      </article>
      
    </div>
